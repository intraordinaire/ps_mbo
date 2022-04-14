'use strict';
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */


function getDashboardMBONewsBlogRss(dashboardNewsAjaxUrl, translationsDashboardMbo) {
  if(!dashboardNewsAjaxUrl || ! translationsDashboardMbo || !translationsDashboardMbo.new_read_more) {
    return;
  }
  $.ajax({
    url: dashboardNewsAjaxUrl,
    data: {
      ajax: true,
      action: 'getBlogRss'
    },
    dataType: 'json',
    success: function(jsonData) {
      if (typeof jsonData !== 'undefined' && jsonData !== null && !jsonData.has_errors) {
        for (var article in jsonData.rss) {
          var article_html = '<article><h4><a href="'+jsonData.rss[article].link+'" target="_blank" rel="noopener noreferrer nofollow" onclick="return !window.open(this.href);">'+jsonData.rss[article].title+'</a></h4><span class="dash-news-date text-muted">'+jsonData.rss[article].date+'</span><p>'+jsonData.rss[article].short_desc+' <a href="'+jsonData.rss[article].link+'" target="_blank" rel="noopener noreferrer nofollow" onclick="return !window.open(this.href);">'+translationsDashboardMbo.new_read_more+'</a><p></article><hr/>';
          $('.dash_news .dash_news_content').append(article_html);
        }
      }
      else {
        $('.dash_news').hide();
      }
    }
  });
}
