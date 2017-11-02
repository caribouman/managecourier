<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LettersTagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LettersTagsTable Test Case
 */
class LettersTagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LettersTagsTable
     */
    public $LettersTags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.letters_tags',
        'app.letters',
        'app.tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LettersTags') ? [] : ['className' => 'App\Model\Table\LettersTagsTable'];
        $this->LettersTags = TableRegistry::get('LettersTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LettersTags);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
