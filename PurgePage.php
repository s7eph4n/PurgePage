<?php

namespace PurgePage;

use Job;
use JobQueueGroup;
use Title;

class PurgePage {

	public static function init() {
		$GLOBALS[ 'wgExtensionMessagesFiles' ][ 'PurgePageMagic' ] = __DIR__ . '/PurgePage.magic.php';
		$GLOBALS[ 'wgJobClasses' ][ 'parsePage' ] = 'PurgePage\\PageParseJob';
	}

	public static function registerParserFunction( \Parser &$parser ) {

		$parser->setFunctionHook( 'purge', function () {

			$params = func_get_args();

			if ( isset( $params[ 1 ] ) ) {

				$parser = $params[ 0 ];
				$pageName = $params[ 1 ];

				$title = Title::newFromText( $pageName );

				if ( $title !== null && $title->isContentPage() && $title->exists() ) {
					/** @var \ParserOptions $parserOptions */
					$parserOptions = $parser->getOptions();
					$job           = Job::factory( 'parsePage', $title, [ 'user' => $parserOptions->getUser(), 'lang' => $parserOptions->getUserLang() ] );
					JobQueueGroup::singleton()->lazyPush( $job );
				}


			}

		} );

		return true;
	}
}
