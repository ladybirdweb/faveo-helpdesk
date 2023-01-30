<?php

use GuzzleHttp\Psr7\Response;
use LaravelFCM\Response\TopicResponse;

class TopicsResponseTest extends FCMTestCase
{
    /**
     * @test
     */
    public function it_construct_a_topic_response_with_success()
    {
        $topic = new \LaravelFCM\Message\Topics();
        $topic->topic('topicName');

        $response = new Response(200, [], '{ 
				"message_id": "1234"
		}');

        $topicResponse = new TopicResponse($response, $topic);

        $this->assertTrue($topicResponse->isSuccess());
        $this->assertFalse($topicResponse->shouldRetry());
        $this->assertNull($topicResponse->error());
    }

    /**
     * @test
     */
    public function it_construct_a_topic_response_with_error()
    {
        $topic = new \LaravelFCM\Message\Topics();
        $topic->topic('topicName');

        $response = new Response(200, [], '{ 
				"error": "MessageTooBig"
		}');

        $topicResponse = new TopicResponse($response, $topic);

        $this->assertFalse($topicResponse->isSuccess());
        $this->assertFalse($topicResponse->shouldRetry());
        $this->assertEquals('MessageTooBig', $topicResponse->error());
    }

    /**
     * @test
     */
    public function it_construct_a_topic_response_with_error_and_it_should_retry()
    {
        $topic = new \LaravelFCM\Message\Topics();
        $topic->topic('topicName');

        $response = new Response(200, [], '{ 
				"error": "TopicsMessageRateExceeded"
		}');

        $topicResponse = new TopicResponse($response, $topic);

        $this->assertFalse($topicResponse->isSuccess());
        $this->assertTrue($topicResponse->shouldRetry());
        $this->assertEquals('TopicsMessageRateExceeded', $topicResponse->error());
    }
}
