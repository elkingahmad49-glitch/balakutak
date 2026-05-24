<?php

namespace App\Helpers;

class HtmlHelper
{
    /**
     * Fix unclosed HTML tags in an HTML fragment.
     *
     * @param string $html
     * @return string
     */
    public static function fixHtmlTags($html)
    {
        if (empty($html) || empty(trim($html))) {
            return $html;
        }

        // Create DOMDocument instance
        $dom = new \DOMDocument();

        // Prevent errors on invalid HTML5 tags or attributes
        libxml_use_internal_errors(true);

        // Load HTML. Wrap in div and convert encoding to preserve UTF-8 properly
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        
        // Load the fragment inside a root div
        $dom->loadHTML("<div>" . $html . "</div>", LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        libxml_clear_errors();

        // Retrieve and return the inner HTML of our wrapper div
        $output = '';
        $wrapper = $dom->getElementsByTagName('div')->item(0);
        if ($wrapper) {
            foreach ($wrapper->childNodes as $child) {
                $output .= $dom->saveHTML($child);
            }
        } else {
            $output = $dom->saveHTML();
        }

        return $output;
    }
}
