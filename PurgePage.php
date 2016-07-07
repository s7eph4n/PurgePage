<?php

namespace PurgePage;

class PurgePage {

	public static function init() {
		$GLOBALS[ 'wgExtensionMessagesFiles' ][ 'PurgePageMagic' ] = __DIR__ . '/PurgePage.magic.php';
	}

	public static function registerParserFunction( \Parser &$parser ) {

		$parser->setFunctionHook( 'purge', function () {

			$params = func_get_args();

			if ( isset( $params[ 1 ] ) ) {

				$pageName = $params[ 1 ];

				$title = \Title::newFromText( $pageName );

				if ( $title->isContentPage() && $title->exists() ) {
					\WikiPage::factory( $title )->doPurge();
				}

			}

		} );

		return true;
	}
}
