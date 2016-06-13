#!/bin/sh

set -e

VERSION=$(perl -MFile::Slurp::Tiny=read_file -MDateTime <<EOF
use v5.16;
my \$log = read_file(q{CHANGELOG.md});
\$log =~ /\n(\d+\.\d+\.\d+) \((\d{4}-\d{2}-\d{2})\)\n/;
die 'Release time is not today!' unless DateTime->now->ymd eq \$2;
say \$1;
EOF
)

perl -pi -e "s/(?<=#define PHP_MAXMINDDB_VERSION \")\d+\.\d+\.\d+(?=\")/$VERSION/" ext/php_maxminddb.h

git diff

if [ -n "$(git status --porcelain)" ]; then
    git commit -m "Bumped version to $VERSION" -a
fi

TAG="v$VERSION"
echo "Creating tag $TAG"
git tag -a -m "Release for $VERSION" "$TAG"


read -p "Push to origin? (y/n) " SHOULD_PUSH

if [ "$SHOULD_PUSH" != "y" ]; then
    echo "Aborting"
    exit 1
fi

git push
git push --tags
