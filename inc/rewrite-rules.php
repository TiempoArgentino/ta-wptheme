<?php

class Theme_Permalinks
{

    public function __construct()
    {
        add_filter('request', [$this, 'ta_section_change_request'], 1, 1);
        add_filter('term_link', [$this, 'ta_section_permalink'], 10, 3);
    }

    public function ta_section_change_request($query)
    {
        $name = '';
        $tax_name = 'ta_article_section';

        if (isset($query['attachment'])) :
            $include_children = true;
            $name = $query['attachment'];
        elseif(isset($query['name'])):
            $include_children = false;
            $name = $query['name'];
        else:
            $name = '';
        endif;


        $term = get_term_by('slug', $name, $tax_name);

        if (isset($name) && $term && !is_wp_error($term)) :

            if ($include_children) {
                unset($query['attachment']);
                $parent = $term->parent;
                while ($parent) {
                    $parent_term = get_term($parent, $tax_name);
                    $name = $parent_term->slug . '/' . $name;
                    $parent = $parent_term->parent;
                }
            } else {
                unset($query['name']);
            }

            switch ($tax_name):
                case 'ta_article_section': {
                        $query['ta_article_section'] = $name;
                        break;
                    }
                default: {
                        $query[$tax_name] = $name;
                        break;
                    }
            endswitch;

        endif;

        return $query;
    }

    public function ta_section_permalink($url, $term, $taxonomy)
    {

        $taxonomy_name = 'ta_article_section';
        $taxonomy_slug = 'ta_article_section';

        if (strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name) return $url;

        $url = str_replace('/' . $taxonomy_slug, '', $url);

        return $url;
    }
}

function theme_permalinks()
{
    return new Theme_Permalinks();
}

theme_permalinks();
