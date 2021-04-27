<?php
class DRBridge extends BridgeAbstract {
	const NAME = 'DR: Indland';
	const URI = 'https://www.dr.dk';
	const DESCRIPTION = 'Fetches the latest updates from DR: Indland.';
	const MAINTAINER = 'orgron';
	const CACHE_TIMEOUT = 3600; // 1h
	
	/*
	public function getIcon() {
		return 'https://www.dr.dk/global/logos/dr.png';
	}
	*/
	
	public function collectData() {
		$html = getSimpleHTMLDOM(self::URI . '/nyheder/indland/')
			or returnServerError('Could not fetch latest updates from DR: Indland.');
		
		foreach($html->find('div.dre-teaser-content') as $element) {
			$a = $element->find('a.dre-teaser-title', 0);
			
			$href = self::URI . $a->href;

			//$full = getSimpleHTMLDOM($href);
			$full = getSimpleHTMLDOMCached($href);
			$article = $full->find('article', 0);
			//$rofl = $full->find('p[class="dre-article-body-paragraph"]', 0);
			$header = $article->find('h1[itemprop="headline"]', 0);
			$content = $article->find('div[class="dre-article-body"]', 0);
			//$content = $articlebody->find('div[class="dre-container__content dre-container__content--small"]');
			
			// Remove newsletter subscription box
			$newsletter = $content->find('div[class="hydra-marketing-banner"]', 0);
			if ($newsletter)
				$newsletter->outertext = '';
			
			// Remove the oversized quotation mark
			$quote = $content->find('div[class="dre-block-quote__icon"]');
			if ($quote)
				$quote->outertext = '';
			
			
			$item = array(); // Create a new item
			
			
			$item['title'] = $header->innertext;
			$item['content'] = $content->innertext;
			$item['uri'] = $href;
			
			$this->items[] = $item; // Add item to the list
			
			/*
			$headerimg = $article->find('picture[class="dre-picture__picture"]', 0)->find('img', 0);
			$author = $article->find('span[itemprop="name"]', 0);
			$time = $article->find('time', 0);
			
			
			
			$section = array( $article->find('div[class="dre-article-title__section-label"]', 0)->plaintext );

			// Author
			if ($author)
				$author = substr($author->innertext, 3, strlen($author));
			else
				$author = 'DR';
			
			

			$newsletterForm = $content->find('form', 0);
			if ($newsletterForm)
				$newsletterForm->outertext = '';
			
			// Remove next and previous article URLs at the bottom
			$nextprev = $content->find('div[class="blog-post__next-previous-wrapper"]', 0);
			if ($nextprev)
				$nextprev->outertext = '';
			*/
			
			/*
			$item = array();
			$item['title'] = $header->innertext;
			*/
			/*
			$item['uri'] = $href;
			$item['timestamp'] = strtotime($time->datetime);
			$item['author'] = $author;
			$item['categories'] = $section;

			$item['content'] = '<img style="max-width: 100%" src="'
				. $headerimg->src . '">' . $content->innertext;
			*/
			//$this->items[] = $item;

			if (count($this->items) >= 10)
				break;
			
		}
	}
}

