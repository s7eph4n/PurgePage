<?php

namespace PurgePage;

use PoolWorkArticleView;

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

				$title = \Title::newFromText( $pageName );
				$job = \Job::factory( 'parsePage', $title, [ 'parseroptions' => $parser->getOptions() ] );

				\JobQueueGroup::singleton()->lazyPush( [ $job ] );

			}

		} );

		return true;
	}
}
