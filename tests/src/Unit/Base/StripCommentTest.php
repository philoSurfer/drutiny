<?php

use PHPUnit\Framework\TestCase;

use Drutiny\Base\StringLib;

/**
 * @coversDefaultClass \Drutiny\Base\StringLib
 */
class StripCommentTest extends TestCase {

  /**
   * @covers ::stripComments
   * @dataProvider contentsProvider
   * @group base
   */
  public function testStripComments($input, $expected) {
    $this->assertEquals(StringLib::stripComments($input), $expected);
  }

  /**
   * DataProvider for testStripComments().
   */
  public function contentsProvider() {
    return [
      // Test that <?php is replaced.
      ['<?php   ', ''],
      ['<?php
// @see http://cgit.drupalcode.org/module_missing_message_fixer/tree/includes/module_missing_message_fixer.drush.inc
$rows = [];', '$rows = [];',
      ],
      ['<?php

// @see http://cgit.drupalcode.org/module_missing_message_fixer/tree/includes/module_missing_message_fixer.drush.inc

$rows = [];', '$rows = [];',
      ],

      // Comment after code should stay.
      ['$var = "blah"; // comment on the end.', '$var = "blah"; // comment on the end.'],

      // Test the double slash comment.
      ['// comment at the beginning.', ''],
      ['        // comment.', ''],
      ["\t// comment.", ''],
      ["\t\t\t// comment.", ''],
      ["\t\t\t  // comment.", ''],

      // Test the hash comment.
      ['# comment at the beginning.', ''],
      ['        # comment.', ''],
      ["\t# comment.", ''],
      ["\t\t\t# comment.", ''],
      ["\t\t\t  # comment.", ''],

      // Mix of space and comments.
      ['        // comment.

                // comment.

                // comment.', '',
      ],

      // URLs have double slashes in them.
      ['$var = "http://www.google.com".', '$var = "http://www.google.com".'],
    ];
  }

}
