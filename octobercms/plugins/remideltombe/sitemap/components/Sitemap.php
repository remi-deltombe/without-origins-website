<?php namespace RemiDeltombe\Sitemap\Components;

use RemiDeltombe\Page\Models\Page;
use RemiDeltombe\News\Models\Item as NewsItem;

class Sitemap extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {   
        return [
            'name' => 'Sitemap',
            'description' => 'Displays sitemap as xml.'
        ];
    }

    public function urls()
    {
        $urls = [];

        // Homepage
        //$urls[] = [ 'link' => url('/'), 'last'=>'0000-00-00'];

        // Page
        foreach (Page::all() as $page) {
            $urls[] = [ 'link' => url($page->link()), 'last'=>$page->updated_at];
        }

        //News
        foreach (NewsItem::all() as $news) {
            $urls[] = [ 'link' => url($news->link()), 'last'=>$news->updated_at];
        }

        return $urls;
    }
}