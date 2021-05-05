<?php
class DRBridge extends BridgeAbstract {
	const NAME = 'DR: Indland';
	const URI = 'https://www.dr.dk';
	const DESCRIPTION = 'Fetches the latest updates from DR: Indland.';
	const MAINTAINER = 'orgron';
	const CACHE_TIMEOUT = 3600; // 1h
	
	public function collectData() {
		$html = getSimpleHTMLDOM(self::URI . '/nyheder/indland/')
			or returnServerError('Could not fetch latest updates from DR: Indland.');
		
		foreach($html->find('div.dre-teaser-content') as $element) {
			$a = $element->find('a.dre-teaser-title', 0);
			/*
			$href = self::URI . $a->href;
			$full = getSimpleHTMLDOMCached($href);
			$article = $full->find('article', 0);
			$header = $article->find('h1[itemprop="headline"]', 0);
			$content = $article->find('div[class="dre-article-body"]', 0);

			// Remove the oversized quotation marks
			foreach($content->find('div[class="dre-block-quote__icon"]') as $quote) {
				if ($quote)	$quote->outertext = '';
			}
			
			// Remove the placeholders
			foreach($content->find('div[class="dre-placeholder"]') as $placeholder) {
				if ($placeholder)	$placeholder->outertext = '';
			}
			
			$headerimg = $article->find('div[class="dre-picture"]', 0)->find('img', 0);
			$author = $article->find('div[class="dre-byline__authors"]', 0);
			*/
			$item = array(); // Create a new item
			
			/*
			$item['title'] = $header->innertext;
			$item['content'] = '<img style="max-width: 100%" src="'
				. $headerimg->src . '">' . $content->innertext;
			$item['uri'] = $href;
			$item['author'] = $author->innertext;
			*/
			$item['content'] = $a;
			$this->items[] = $item; // Add item to the list

			if (count($this->items) >= 10)
				break;
			
		}
	}

}

