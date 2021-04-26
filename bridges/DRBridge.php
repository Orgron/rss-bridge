<?php
class DRBridge extends BridgeAbstract {
	const NAME = 'DR: Indland';
	const URI = 'https://www.dr.dk/nyheder/indland';
	const DESCRIPTION = 'Fetches the latest updates from DR: Indland.';
	const MAINTAINER = 'orgron';
	const CACHE_TIMEOUT = 3600; // 1h

	public function getIcon() {
		return 'https://www.dr.dk/global/logos/dr.png';
	}

	public function collectData() {
		$html = getSimpleHTMLDOM(self::URI)
			or returnServerError('Could not fetch latest updates from DR: Indland.');

		/*foreach($html->find('div.teaser') as $element) {

			$a = $element->find('a.dre-teaser-title', 0);
			$href = $a->href;

			if (substr($href, 0, 4) != 'http')
				$href = self::URI . $a->href;

			$full = getSimpleHTMLDOMCached($href);
			$article = $full->find('article', 0);
			$header = $article->find('span[class="dre-title-text dre-title-text--prefixed"]', 0);
			$headerimg = $article->find('div[class="dre-article-hero-top__image"]', 0)->find('img', 0);
			$author = $article->find('span[itemprop="name"]', 0);
			$time = $article->find('time', 0);
			$content = $article->find('div[itemprop="text"]', 0);
			$section = array( $article->find('strong[itemprop="articleSection"]', 0)->plaintext );

			// Author
			if ($author)
				$author = substr($author->innertext, 3, strlen($author));
			else
				$author = 'DR';

			// Remove newsletter subscription box
			$newsletter = $content->find('div[class="newsletter-form__message"]', 0);
			if ($newsletter)
				$newsletter->outertext = '';

			$newsletterForm = $content->find('form', 0);
			if ($newsletterForm)
				$newsletterForm->outertext = '';

			// Remove next and previous article URLs at the bottom
			$nextprev = $content->find('div[class="blog-post__next-previous-wrapper"]', 0);
			if ($nextprev)
				$nextprev->outertext = '';

			$item = array();
			$item['title'] = $header->innertext;
			$item['uri'] = $href;
			$item['timestamp'] = strtotime($time->datetime);
			$item['author'] = $author;
			$item['categories'] = $section;

			$item['content'] = '<img style="max-width: 100%" src="'
				. $headerimg->src . '">' . $content->innertext;

			$this->items[] = $item;

			if (count($this->items) >= 10)
				break;
		
		}
		*/
	}
}
