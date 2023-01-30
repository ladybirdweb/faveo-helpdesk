<?php

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LaravelFCM\Message\Topics;
use LaravelFCM\Sender\FCMSender;
use LaravelFCM\Message\Exceptions\NoTopicProvidedException;

class TopicsTest extends FCMTestCase
{
    /**
     * @test
     */
    public function it_throw_an_exception_if_no_topic_is_provided()
    {
        $topics = new Topics();

        $this->setExpectedException(NoTopicProvidedException::class);
        $topics->build();
    }

    /**
     * @test
     */
    public function it_has_only_one_topic()
    {
        $target = '/topics/myTopic';

        $topics = new Topics();

        $topics->topic('myTopic');

        $this->assertEquals($target, $topics->build());
    }

    /**
     * @test
     */
    public function it_has_two_topics_and()
    {
        $target = [
            'condition' => "'firstTopic' in topics && 'secondTopic' in topics",
        ];

        $topics = new Topics();

        $topics->topic('firstTopic')->andTopic('secondTopic');

        $this->assertEquals($target, $topics->build());
    }

    /**
     * @test
     */
    public function it_has_two_topics_or()
    {
        $target = [
            'condition' => "'firstTopic' in topics || 'secondTopic' in topics",
        ];

        $topics = new Topics();

        $topics->topic('firstTopic')->orTopic('secondTopic');

        $this->assertEquals($target, $topics->build());
    }

    /**
     * @test
     */
    public function it_has_two_topics_or_and_one_and()
    {
        $target = [
            'condition' => "'firstTopic' in topics || 'secondTopic' in topics && 'thirdTopic' in topics",
        ];

        $topics = new Topics();

        $topics->topic('firstTopic')->orTopic('secondTopic')->andTopic('thirdTopic');

        $this->assertEquals($target, $topics->build());
    }

    /**
     * @test
     */
    public function it_has_a_complex_topic_condition()
    {
        $target = [
            'condition' => "'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics) || ('TopicD' in topics && 'TopicE' in topics)",
        ];

        $topics = new Topics();

        $topics->topic('TopicA')
               ->andTopic(function ($condition) {
                   $condition->topic('TopicB')->orTopic('TopicC');
               })
               ->orTopic(function ($condition) {
                   $condition->topic('TopicD')->andTopic('TopicE');
               });

        $this->assertEquals($target, $topics->build());
    }

    /**
     * @test
     */
    public function it_send_a_notification_to_a_topic()
    {
        $response = new Response(200, [], '{"message_id":6177433633397011933}');

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

        $fcm = new FCMSender($client, 'http://test.test');

        $topics = new Topics();
        $topics->topic('test');

        $response = $fcm->sendToTopic($topics);

        $this->assertTrue($response->isSuccess());
        $this->assertFalse($response->shouldRetry());
        $this->assertNull($response->error());
    }

    /**
     * @test
     */
    public function it_send_a_notification_to_a_topic_and_return_error()
    {
        $response = new Response(200, [], '{"error":"TopicsMessageRateExceeded"}');

        $client = Mockery::mock(Client::class);
        $client->shouldReceive('request')->once()->andReturn($response);

        $fcm = new FCMSender($client, 'http://test.test');

        $topics = new Topics();
        $topics->topic('test');

        $response = $fcm->sendToTopic($topics);

        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->shouldRetry());
        $this->assertEquals('TopicsMessageRateExceeded', $response->error());
    }
}
