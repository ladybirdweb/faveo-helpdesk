<?php

namespace mjanssen\BreadcrumbsBundle;

use mjanssen\BreadcrumbsBundle\package\SingleBreadcrumb as SingleCrumb;

class Breadcrumbs {

    private static $_breadcrumbs = [], $_config;

    public static $separator;

    public static function createBreadcrumb($name, $url)
    {
        return new SingleCrumb($name, $url);
    }

    public static function addBreadcrumb($name, $url)
    {
        $b = self::createBreadcrumb($name, $url);

        self::$_breadcrumbs[] = $b;
    }

    public static function prepend($b)
    {
        array(array_unshift(self::$_breadcrumbs, $b));
    }

    public static function generate()
    {
        $output = '';
        $count  = 1;

        self::$_config = config('breadcrumbs');

        self::isFirstBreadcrumb();

        if (isset(self::$_config['useSeparator']) && self::$_config['useSeparator'] === true && self::$_config['separator'] != '') {
            $separator = self::$_config['separator'];
        } else {
            if (isset(self::$_config['bootstrapSeparator']) && self::$_config['bootstrapSeparator'] === true) {
                $separator = '';
            } else {
                $separator = '/';
            }
        }

        self::$separator = $separator;

        $totalBreadcrumbs = self::getBreadcrumbAmount();

        $output .= '<div itemscope itemtype="http://schema.org/WebPage">';

        $class = (isset(self::$_config['bootstrap']) && self::$_config['bootstrap'] === true)
                    ? "breadcrumb"
                    : (isset(self::$_config['ulLiClass'])
                        ? self::$_config['ulLiClass']
                        : "") ;

        $output .= '<ol class="'.$class.'" itemprop="breadcrumb">';

        foreach (self::$_breadcrumbs as $breadcrumb) {

            if ($count === $totalBreadcrumbs && isset(self::$_config['lastBreadcrumbClickable']) && self::$_config['lastBreadcrumbClickable'] === false) {
                $output .= '<li class="active">' . $breadcrumb->name . '</li>';
            } else {
                $output .= '<li>' . $breadcrumb->crumb . '</li>';
            }

            if ($count < $totalBreadcrumbs) {
                $output .= ' ' . self::$separator . '</li>';
            }

            $count++;
        }

        $output .= '</ol>';
        $output .= '</div>';
        $output .= '<div class="clearfix"></div>';

        return $output;
    }

    public static function getBreadcrumbAmount()
    {
        return count(self::$_breadcrumbs);
    }

    public static function automatic()
    {
        self::$_config = config('breadcrumbs');

        $parts = \Request::segments();
		$current = "";

        foreach ($parts as $part) {

            $title = str_replace("-", " ", $part);
			$current .= "/" . $part;

            if (!in_array($title, self::$_config['except'])) {

                self::addBreadcrumb($title, url($current));
            }
        }

        return self::generate();
    }

    public static function truncate()
    {
        self::$_breadcrumbs = [];
    }

    private static function isFirstBreadcrumb()
    {
        if (isset(self::$_config['automaticFirstCrumb']) && self::$_config['automaticFirstCrumb']['enabled'] === true) {
            self::prepend( self::createBreadcrumb(self::$_config['automaticFirstCrumb']['value'], url('/')) );
        }
    }
}