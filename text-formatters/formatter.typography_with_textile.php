<?php

	include_once(EXTENSIONS . '/typography_text_formatters/lib/html_helpers.php');

	Class formatterTypography_With_Textile extends TextFormatter {

		private static $_parser;
		private static $_typo;

		function about(){
			return array(
			  'name' => 'Typography + Textile Text Formatter',
				'version' => '1.0.2',
				'release-date' => '2012-05-14',
				'author' => array(
					'name' => 'Tony Arnold',
					'website' => 'http://www.tonyarnold.com',
					'email' => 'tony@tonyarnold.com'
				),
				'description' => 'Format entries using Textile, then using the PHP Typography HTML formatter.'
			);
		}

		public function run($string) {
			if (!self::$_parser) {
				include_once(EXTENSIONS . '/typography_text_formatters/lib/textile.php');
				self::$_parser = new Textile();
			}

			if (!self::$_typo) {
				include_once(EXTENSIONS . '/typography_text_formatters/lib/php-typography/php-typography.php');
				self::$_typo = new phpTypography();
				self::$_typo->set_hyphenation(false);
			}

			$result = self::$_parser->TextileThis($string);
			$result = self::$_typo->process($result);
			$result = utf8tohtml($result, FALSE);
			$result = html_convert_entities($result);

			return $result;
		}

	}

