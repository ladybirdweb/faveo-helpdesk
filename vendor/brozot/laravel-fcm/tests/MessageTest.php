<?php

use LaravelFCM\Message\Exceptions\InvalidOptionsException;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\OptionsPriorities;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PayloadTest extends FCMTestCase
{
    /**
     * @test
     */
    public function it_construct_a_valid_json_with_option()
    {
        $targetPartial = '{
					"collapse_key":"collapseKey",
					"content_available":true
				}';

        $targetFull = '{
					"collapse_key":"collapseKey",
					"content_available":true,
					"priority":"high",
					"delay_while_idle":true,
					"time_to_live":200,
					"restricted_package_name":"customPackageName",
					"dry_run": true
				}';

        $optionBuilder = new OptionsBuilder();

        $optionBuilder->setCollapseKey('collapseKey');
        $optionBuilder->setContentAvailable(true);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetPartial, $json);

        $optionBuilder->setPriority(OptionsPriorities::high)
            ->setDelayWhileIdle(true)
            ->setDryRun(true)
            ->setRestrictedPackageName('customPackageName')
            ->setTimeToLive(200);

        $json = json_encode($optionBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetFull, $json);
    }

    /**
     * @test
     */
    public function it_construct_a_valid_json_with_data()
    {
        $targetAdd = '{
				"first_data":"first",
				"second_data":true
			}';

        $targetSet = '
				{
					"third_data":"third",
					"fourth_data":4
				}';

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder->addData(['first_data' => 'first'])
            ->addData(['second_data' => true]);

        $json = json_encode($dataBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetAdd, $json);

        $dataBuilder->setData(['third_data' => 'third', 'fourth_data' => 4]);

        $json = json_encode($dataBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetSet, $json);
    }

    /**
     * @test
     */
    public function it_construct_a_valid_json_with_notification()
    {
        $targetPartial = '{
					"title":"test_title",
					"body":"test_body",
					"badge":"test_badge",
					"sound":"test_sound"
				}';

        $targetFull = '{
					"title":"test_title",
					"body":"test_body",
					"android_channel_id":"test_channel_id",
					"badge":"test_badge",
					"sound":"test_sound",
					"tag":"test_tag",
					"color":"test_color",
					"click_action":"test_click_action",
					"body_loc_key":"test_body_key",
					"body_loc_args":"[ body0, body1 ]",
					"title_loc_key":"test_title_key",
					"title_loc_args":"[ title0, title1 ]",
					"icon":"test_icon"
				}';

        $notificationBuilder = new PayloadNotificationBuilder();

        $notificationBuilder->setTitle('test_title')
                    ->setBody('test_body')
                    ->setSound('test_sound')
                    ->setBadge('test_badge');

        $json = json_encode($notificationBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetPartial, $json);

        $notificationBuilder
                    ->setChannelId('test_channel_id')
                    ->setTag('test_tag')
                    ->setColor('test_color')
                    ->setClickAction('test_click_action')
                    ->setBodyLocationKey('test_body_key')
                    ->setBodyLocationArgs('[ body0, body1 ]')
                    ->setTitleLocationKey('test_title_key')
                    ->setTitleLocationArgs('[ title0, title1 ]')
                    ->setIcon('test_icon');

        $json = json_encode($notificationBuilder->build()->toArray());
        $this->assertJsonStringEqualsJsonString($targetFull, $json);
    }

    /**
     * @test
     */
    public function it_throws_an_invalidoptionsexception_if_the_interval_is_too_big()
    {
        $this->setExpectedException(InvalidOptionsException::class);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(2419200 * 10);

    }
}
