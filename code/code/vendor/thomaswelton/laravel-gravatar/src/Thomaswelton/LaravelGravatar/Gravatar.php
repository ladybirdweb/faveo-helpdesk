<?php namespace Thomaswelton\LaravelGravatar;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Support\Facades\HTML;
use thomaswelton\GravatarLib\Gravatar as GravatarLib;

class Gravatar extends GravatarLib
{
    private $defaultSize = null;

    public function __construct(Config $config)
    {
        // Set default configuration values
        $this->setDefaultImage($config->get('gravatar.default'));
        $this->defaultSize = $config->get('gravatar.size');
        $this->setMaxRating($config->get('gravatar.maxRating', 'g'));

        // Enable secure images by default
        $this->enableSecureImages();
    }

    public function src($email, $size = null, $rating = null)
    {
        if (is_null($size))
        {
            $size = $this->defaultSize;
        }

        $size = max(1, min(512, $size));

        $this->setAvatarSize($size);

        if ( ! is_null($rating))
        {
            $this->setMaxRating($rating);
        }

        return htmlentities($this->buildGravatarURL($email));
    }

    public function image($email, $alt = null, $attributes = array(), $rating = null)
    {
        $dimensions = array();

        if (array_key_exists('width', $attributes)) $dimensions[] = $attributes['width'];
        if (array_key_exists('height', $attributes)) $dimensions[] = $attributes['height'];

        $max_dimension = (count($dimensions)) ? min(512, max($dimensions)) : $this->defaultSize;

        $src = $this->src($email, $max_dimension, $rating);

        if ( ! array_key_exists('width', $attributes) && !array_key_exists('height', $attributes))
        {
            $attributes['width'] = $this->size;
            $attributes['height'] = $this->size;
        }

        return $this->formatImage($src, $alt, $attributes);
    }

    public function exists($email)
	{
		$this->setDefaultImage('404');

		$url = $this->buildGravatarURL($email);
		$headers = get_headers($url, 1);

		return strpos($headers[0], '200') ? true : false;
	}

    private function formatImage($src, $alt, $attributes)
    {
        return '<img src="'.$src.'" alt="'.$alt.'" height="'.$attributes['height'].'" width="'.$attributes['width'].'">';
    }
}
