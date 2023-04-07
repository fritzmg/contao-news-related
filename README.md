[![](https://img.shields.io/packagist/v/fritzmg/contao-news-related.svg)](https://packagist.org/packages/fritzmg/contao-news-related)
[![](https://img.shields.io/packagist/dt/fritzmg/contao-news-related.svg)](https://packagist.org/packages/fritzmg/contao-news-related)

Contao News Related
===================

Simple Contao 4+ bundle for setting related news directly.

This is different from creating relations via categories or tags, since you have to define the related news for each individual article yourself. Note that the direction of relation goes only one way - so if you want article _A_ to be related to article _B_, but also vice versa, you have to assign the relation in article _B_ as well.

To use this functionality you have to create a newslist module and enable the **Show only related entries** setting. Include this module then on the same page as the newsreader module.

_Note:_ install [`inspiredminds/contao-categories-news-filter`](https://github.com/inspiredminds/contao-categories-news-filter) to restore compatibility with [`codefog/contao-news_categories`](https://github.com/codefog/contao-news_categories).
