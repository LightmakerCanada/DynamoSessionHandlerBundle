<?php

use Lightmaker\DynamoSessionHandlerBundle\Session\Storage\DynamoDbSessionHandler;
use Aws\Common\Aws;

class DynamoDbSessionHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $aws;
    public  $options;

    /**
     * Create an instance of the AWS SDK
     */
    protected function setUp()
    {

        $awsConfig = array();
        $awsConfig['region'] = 'us-east-1';

        $this->aws = Aws::factory( $awsConfig )->enableFacades();

        $this->options = array(
            'table_name' => 'session',
            'hash_key'   => 'id'
        );

    }

    /**
     * @param string $method
     * @param int $expects
     * @param mixed $returnValue
     */
    public function setupSessionHandlerMock( $method, $expects, $returnValue )
    {

        // Mock the DynamoDb client `sessionHandler`
        $sessionHandler = $this->getMockBuilder( 'Aws\DynamoDb\Session\SessionHandler' )
                               ->disableOriginalConstructor()
                               ->getMock();

        $sessionHandler->expects( $this->exactly( $expects ) )
                       ->method( $method )
                       ->will( $this->returnValue( $returnValue ) );

        // Mock the `registerSessionHandler` method of DynamoDb client
        $mockDynamoClient = $this->getMockBuilder( 'Aws\DynamoDb\DynamoDbClient' )
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $mockDynamoClient->expects( $this->any() )
                         ->method( 'registerSessionHandler' )
                         ->will( $this->returnValue( $sessionHandler ) );

        // Set the DynamoDb client mock
        $this->aws->set( 'DynamoDb', $mockDynamoClient );

    }

    public function testOpenMethodAlwaysReturnTrue()
    {
        $this->setupSessionHandlerMock( 'open', 1, true );
        $storage = new DynamoDbSessionHandler( $this->aws, $this->options );
        $this->assertTrue( $storage->open( 'test', 'test' ), 'The "open" method should always return true' );
    }

    public function testCloseMethodAlwaysReturnTrue()
    {
        $this->setupSessionHandlerMock( 'close', 1, true );
        $storage = new DynamoDbSessionHandler( $this->aws, $this->options );
        $this->assertTrue( $storage->close(), 'The "close" method should always return true' );
    }

    public function testDestroyMethodAlwaysReturnTrue()
    {
        $this->setupSessionHandlerMock( 'destroy', 1, true );
        $storage = new DynamoDbSessionHandler( $this->aws, $this->options );
        $this->assertTrue( $storage->destroy( 'abc123' ), 'The "destroy" method should always return true' );
    }

    public function testGcMethodAlwaysReturnsTrue()
    {
        $this->setupSessionHandlerMock( 'gc', 1, true );
        $storage = new DynamoDbSessionHandler( $this->aws, $this->options );
        $this->assertTrue( $storage->gc( 100 ), 'The "gc" method should always return true' );
    }

    public function testWriteMethodAlwaysReturnsTrue()
    {
        $this->setupSessionHandlerMock( 'write', 1, true );
        $storage = new DynamoDbSessionHandler( $this->aws, $this->options );
        $this->assertTrue( $storage->write( 'abc123', 'sessoin_data' ), 'The write" method should always return true' );
    }

    public function testReadMethodReturnsData()
    {
        $this->setupSessionHandlerMock( 'read', 1, 'session_data' );
        $storage = new DynamoDbSessionHandler( $this->aws, $this->options );
        $this->assertEquals(
            'session_data',
            $storage->read( 'abc123' ),
            'The "read" method should return "session_data"'
        );
    }


}