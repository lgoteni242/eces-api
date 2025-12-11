<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * Génère une URL d'image depuis Unsplash Source
     * 
     * @param int $width Largeur de l'image
     * @param int $height Hauteur de l'image
     * @param string|null $category Catégorie d'image (optionnel)
     * @return string URL de l'image
     */
    public static function unsplash(int $width = 800, int $height = 600, ?string $category = null): string
    {
        $categories = [
            'product' => ['technology', 'electronics', 'gadgets'],
            'food' => ['food', 'restaurant', 'cooking'],
            'people' => ['people', 'portrait', 'business'],
            'nature' => ['nature', 'landscape', 'outdoor'],
            'business' => ['business', 'office', 'work'],
            'education' => ['education', 'school', 'learning'],
            'event' => ['event', 'party', 'celebration'],
            'hotel' => ['hotel', 'travel', 'accommodation'],
        ];

        if ($category && isset($categories[$category])) {
            $randomCategory = $categories[$category][array_rand($categories[$category])];
            return "https://source.unsplash.com/{$width}x{$height}/?{$randomCategory}&sig=" . rand(1, 1000);
        }

        return "https://source.unsplash.com/{$width}x{$height}/?sig=" . rand(1, 10000);
    }

    /**
     * Génère une URL d'image depuis Lorem Picsum
     */
    public static function picsum(int $width = 800, int $height = 600, ?int $seed = null): string
    {
        $seed = $seed ?? rand(1, 1000);
        return "https://picsum.photos/seed/{$seed}/{$width}/{$height}";
    }

    /**
     * Génère une URL d'image pour un produit
     */
    public static function product(): string
    {
        return self::unsplash(600, 600, 'product');
    }

    /**
     * Génère une URL d'image pour un post
     */
    public static function post(): string
    {
        return self::unsplash(800, 600, 'people');
    }

    /**
     * Génère une URL d'image pour un cours
     */
    public static function course(): string
    {
        return self::unsplash(800, 500, 'education');
    }

    /**
     * Génère une URL d'image pour un restaurant/hôtel
     */
    public static function establishment(): string
    {
        return self::unsplash(800, 600, 'food');
    }

    /**
     * Génère une URL d'image pour un événement
     */
    public static function event(): string
    {
        return self::unsplash(800, 600, 'event');
    }

    /**
     * Génère une URL d'image pour un profil
     */
    public static function avatar(): string
    {
        return self::unsplash(400, 400, 'people');
    }
}
