<?php
/**
 * File containing the PageParseJob class
 *
 * @copyright (C) 2016, Stephan Gambke
 * @license   GNU General Public License, version 2 (or any later version)
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup ExtensionManager
 */

namespace PurgePage;

use Job;
use Parser;
use ParserOptions;
use PoolWorkArticleView;
use Title;

/**
 * Class PageParseJob
 *
 * @package PurgePage
 * @ingroup ExtensionManager
 */
class PageParseJob extends Job {

	private $mParserOptions;

	/**
	 * Callers should use DuplicateJob::newFromJob() instead
	 *
	 * @param Title $title
	 * @param array $params Job parameters
	 */
	public function __construct( Title $title, array $params ) {
		parent::__construct( 'pageParse', $title, $params );

		$this->mParserOptions = isset( $params[ 'parseroptions' ] ) ? $params[ 'parseroptions' ] : new ParserOptions();

		// this does NOT protect against recursion, it only discards duplicate
		// calls to {{#purge}} on the same page
		$this->removeDuplicates = true;
	}

	/**
	 * Run the job
	 * @return bool Success
	 */
	public function run() {

		$title = $this->getTitle();

		if ( $title->isContentPage() && $title->exists() ) {

			$wikiPage = \WikiPage::factory( $title );
			$pool = new PoolWorkArticleView( $wikiPage, $this->mParserOptions, $wikiPage->getLatest(), false );
			$pool->execute();
		}

		return true;
	}
}
