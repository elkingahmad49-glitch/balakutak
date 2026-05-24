<?php

namespace App\Helpers;

class HtmlHelper
{
    /**
     * Fix unclosed HTML tags in an HTML fragment.
     * 
     * Preserves <style> and <script> tag contents from being mangled
     * by DOMDocument (which converts UTF-8 characters to HTML entities,
     * breaking CSS content properties like content: '✦').
     *
     * @param string $html
     * @return string
     */
    public static function fixHtmlTags($html)
    {
        if (empty($html) || empty(trim($html))) {
            return $html;
        }

        // 1. Extract <style> and <script> blocks before DOMDocument processing
        //    because DOMDocument mangles their contents (e.g. converting ✦ to &#10022;
        //    which doesn't work in CSS).
        $preservedBlocks = [];
        $counter = 0;

        $htmlProcessed = preg_replace_callback(
            '/<(style|script)([\s>])(.*?)<\/\1>/si',
            function ($matches) use (&$preservedBlocks, &$counter) {
                $placeholder = "<!--PRESERVED_BLOCK_{$counter}-->";
                $preservedBlocks[$placeholder] = $matches[0];
                $counter++;
                return $placeholder;
            },
            $html
        );

        // 2. Create DOMDocument instance
        $dom = new \DOMDocument();

        // Prevent errors on invalid HTML5 tags or attributes
        libxml_use_internal_errors(true);

        // Use meta charset tag to handle UTF-8 properly instead of
        // deprecated mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8')
        $dom->loadHTML(
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><div>' . $htmlProcessed . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();

        // 3. Retrieve the inner HTML of our wrapper div
        $output = '';
        $wrapper = $dom->getElementsByTagName('div')->item(0);
        if ($wrapper) {
            foreach ($wrapper->childNodes as $child) {
                $output .= $dom->saveHTML($child);
            }
        } else {
            $output = $dom->saveHTML();
        }

        // Remove the meta tag if it leaked into output
        $output = preg_replace('/<meta[^>]*charset[^>]*>/i', '', $output);

        // 4. Restore preserved <style> and <script> blocks
        foreach ($preservedBlocks as $placeholder => $original) {
            $output = str_replace($placeholder, $original, $output);
        }

        return $output;
    }
}

