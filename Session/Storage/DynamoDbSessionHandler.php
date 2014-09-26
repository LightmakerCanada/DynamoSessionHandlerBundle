<?php

namespace Lightmaker\DynamoSessionHandlerBundle\Session\Storage;

use Aws\Common\Aws;
use Aws\DynamoDb\Session\SessionHandler;

/**
 * DynamoDB session handler
 */
class DynamoDbSessionHandler implements \SessionHandlerInterface
{

    /**
     * @var SessionHandler
     */
    private $sessionHandler;

    /**
     * Constructor.
     *
     * See: http://docs.aws.amazon.com/aws-sdk-php/guide/latest/feature-dynamodb-session-handler.html#configuration
     *
     * List of available options:
     *  * table_name: The name of the DynamoDB table in which to store the sessions. This defaults to sessions.
     *  * hash_key: The name of the hash key in the DynamoDB sessions table. This defaults to id.
     *  * session_lifetime: The lifetime of an inactive session before it should be garbage collected. If it is not provided, then the actual lifetime value that will be used is ini_get('session.gc_maxlifetime').
     *  * consistent_read: Whether or not the session handler should use consistent reads for the GetItem operation. This defaults to true.
     *  * locking_strategy: The strategy used for doing session locking. By default the handler uses the NullLockingStrategy, which means that session locking is not enabled (see the Session Locking section for more information). Valid values for this option include null, 'null', 'pessemistic', or an instance of NullLockingStrategy or PessimisticLockingStrategy
     *  * automatic_gc: Whether or not to use PHP's session auto garbage collection. This defaults to the value of (bool) ini_get('session.gc_probability'), but the recommended value is false. (see the Garbage Collection section for more information).
     *  * gc_batch_size: The batch size used for removing expired sessions during garbage collection. This defaults to 25, which is the maximum size of a single BatchWriteItem operation. This value should also take your provisioned throughput into account as well as the timing of your garbage collection.
     *  * gc_operation_delay: The delay (in seconds) between service operations performed during garbage collection. This defaults to 0. Increasing this value allows you to throttle your own requests in an attempt to stay within your provisioned throughput capacity during garbage collection.
     *  * max_lock_wait_time: Maximum time (in seconds) that the session handler should wait to acquire a lock before giving up. This defaults to 10 and is only used with the PessimisticLockingStrategy.
     *  * min_lock_retry_microtime: Minimum time (in microseconds) that the session handler should wait between attempts to acquire a lock. This defaults to 10000 and is only used with the PessimisticLockingStrategy.
     *  * max_lock_retry_microtime: Maximum time (in microseconds) that the session handler should wait between attempts to acquire a lock. This defaults to 50000 and is only used with the PessimisticLockingStrategy.
     *
     * @param Aws   $aws     The AWS SDK for PHP
     * @param array $options An associative array of field options (see above)
     */
    public function __construct(Aws $aws, array $options)
    {
        $this->sessionHandler = $aws->get('DynamoDb')->registerSessionHandler($options);
    }

    /**
     * {@inheritdoc}
     */
    public function open($savePath, $sessionName)
    {
        return $this->sessionHandler->open($savePath, $sessionName);
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->sessionHandler->close();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        $this->sessionHandler->destroy($sessionId);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function gc($maxLifetime)
    {
        $this->sessionHandler->gc($maxLifetime);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {

        $this->sessionHandler->write($sessionId, $data);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        $data = $this->sessionHandler->read($sessionId);

        return $data;
    }

}
