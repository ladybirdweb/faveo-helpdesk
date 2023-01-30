<?php

use GuzzleHttp\Psr7\Response;
use LaravelFCM\Response\DownstreamResponse;

class DownstreamResponseTest extends FCMTestCase
{
    /**
     * @test
     */
    public function it_construct_a_response_with_a_success()
    {
        $token = 'new_token';

        $response = new Response(200, [], '{
		                    "multicast_id": 108,
                            "success": 1,
                            "failure": 0,
                            "canonical_ids": 0,
                            "results": [
                                { "message_id": "1:08" }
                            ]
						}');

        $downstreamResponse = new DownstreamResponse($response, $token);

        $this->assertEquals(1, $downstreamResponse->numberSuccess());
        $this->assertEquals(0, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());

        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(0, $downstreamResponse->tokensToModify());
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_multiple_successes()
    {
        $tokens = [
            'first_token',
            'second_token',
            'third_token',
        ];

        $response = new Response(200, [], '{
		                    "multicast_id": 108,
                            "success": 3,
                            "failure": 0,
                            "canonical_ids": 0,
                            "results": [
                                { "message_id": "1:01" },
                                { "message_id": "1:02" },
                                { "message_id": "1:03" }
                            ]
						}');

        $downstreamResponse = new DownstreamResponse($response, $tokens);

        $this->assertEquals(3, $downstreamResponse->numberSuccess());
        $this->assertEquals(0, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());

        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(0, $downstreamResponse->tokensToModify());
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_a_failure()
    {
        $token = 'new_token';

        $response = new Response(200, [], '{
		                    "multicast_id": 108,
                            "success": 0,
                            "failure": 1,
                            "canonical_ids": 0,
                            "results": [
                                 { "error": "NotRegistered" }
                            ]
						}');

        $downstreamResponse = new DownstreamResponse($response, $token);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(1, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());
        $this->assertFalse($downstreamResponse->hasMissingToken());

        $this->assertCount(1, $downstreamResponse->tokensToDelete());
        $this->assertEquals($token, $downstreamResponse->tokensToDelete()[ 0 ]);
        $this->assertCount(0, $downstreamResponse->tokensToModify());
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_multiple_failures()
    {
        $tokens = [
            'first_token',
            'second_token',
            'third_token',
            'fourth_token',
        ];

        $response = new Response(200, [], '{
		                    "multicast_id": 108,
                            "success": 0,
                            "failure": 3,
                            "canonical_ids": 0,
                            "results": [
                                 { "error": "NotRegistered" },
                                 { "error": "InvalidRegistration" },
                                 { "error": "NotRegistered" },
                                 { "error": "MissingRegistration"}
                            ]
						}');

        $downstreamResponse = new DownstreamResponse($response, $tokens);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(3, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());
        $this->assertTrue($downstreamResponse->hasMissingToken());

        $this->assertCount(3, $downstreamResponse->tokensToDelete());
        $this->assertEquals($tokens[ 0 ], $downstreamResponse->tokensToDelete()[ 0 ]);
        $this->assertEquals($tokens[ 1 ], $downstreamResponse->tokensToDelete()[ 1 ]);
        $this->assertEquals($tokens[ 2 ], $downstreamResponse->tokensToDelete()[ 2 ]);
        $this->assertCount(0, $downstreamResponse->tokensToModify());
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_a_token_to_change()
    {
        $token = 'new_token';

        $response = new Response(200, [], '{
		                    "multicast_id": 108,
                            "success": 0,
                            "failure": 0,
                            "canonical_ids": 1,
                            "results": [
                                  { "message_id": "1:2342", "registration_id": "32" }
                            ]
						}');

        $downstreamResponse = new DownstreamResponse($response, $token);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(0, $downstreamResponse->numberFailure());
        $this->assertEquals(1, $downstreamResponse->numberModification());

        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(1, $downstreamResponse->tokensToModify());

        $this->assertTrue(array_key_exists($token, $downstreamResponse->tokensToModify()));
        $this->assertEquals('32', $downstreamResponse->tokensToModify()[ $token ]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_multiple_tokens_to_change()
    {
        $tokens = [
            'first_token',
            'second_token',
            'third_token',
        ];

        $response = new Response(200, [], '{
		                    "multicast_id": 108,
                            "success": 0,
                            "failure": 0,
                            "canonical_ids": 3,
                            "results": [
                                 { "message_id": "1:2342", "registration_id": "32" },
                                 { "message_id": "1:2342", "registration_id": "33" },
                                 { "message_id": "1:2342", "registration_id": "34" }
                            ]
						}');

        $downstreamResponse = new DownstreamResponse($response, $tokens);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(0, $downstreamResponse->numberFailure());
        $this->assertEquals(3, $downstreamResponse->numberModification());

        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(3, $downstreamResponse->tokensToModify());

        $this->assertTrue(array_key_exists($tokens[ 0 ], $downstreamResponse->tokensToModify()));
        $this->assertEquals('32', $downstreamResponse->tokensToModify()[ $tokens[ 0 ] ]);

        $this->assertTrue(array_key_exists($tokens[ 1 ], $downstreamResponse->tokensToModify()));
        $this->assertEquals('33', $downstreamResponse->tokensToModify()[ $tokens[ 1 ] ]);

        $this->assertTrue(array_key_exists($tokens[ 2 ], $downstreamResponse->tokensToModify()));
        $this->assertEquals('34', $downstreamResponse->tokensToModify()[ $tokens[ 2 ] ]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_a_token_unavailable()
    {
        $token = 'first_token';

        $response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 1,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "Unavailable" }
	                      ]
					}');

        $downstreamResponse = new DownstreamResponse($response, $token);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(1, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());

        // Unavailable is not an error caused by the token validity. it don't need to be deleted$
        $this->assertCount(0, $downstreamResponse->tokensToModify());
        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(1, $downstreamResponse->tokensToRetry());

        $this->assertEquals($token, $downstreamResponse->tokensToRetry()[0]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_a_token_server_error()
    {
        $token = 'first_token';

        $response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 1,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "InternalServerError" }
	                      ]
					}');

        $downstreamResponse = new DownstreamResponse($response, $token);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(1, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());

        // Unavailable is not an error caused by the token validity. it don't need to be deleted$
        $this->assertCount(0, $downstreamResponse->tokensToModify());
        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(1, $downstreamResponse->tokensToRetry());

        $this->assertEquals($token, $downstreamResponse->tokensToRetry()[0]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_a_token_exceeded()
    {
        $token = 'first_token';

        $response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 1,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "DeviceMessageRateExceeded" }
	                      ]
					}');

        $downstreamResponse = new DownstreamResponse($response, $token);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(1, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());

        // Unavailable is not an error caused by the token validity. it don't need to be deleted$
        $this->assertCount(0, $downstreamResponse->tokensToModify());
        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(1, $downstreamResponse->tokensToRetry());

        $this->assertEquals($token, $downstreamResponse->tokensToRetry()[0]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_a_mixed_token_to_retry()
    {
        $tokens = [
            'first_token',
            'second_token',
            'third_token',
            'fourth_token',
            'fifth_token',
            'sixth_token',
        ];

        $response = new Response(200, [], '{
						  "multicast_id": 216,
						  "success": 0,
						  "failure": 6,
						  "canonical_ids": 0,
						  "results": [
							    { "error": "DeviceMessageRateExceeded" },
							    { "error": "InternalServerError" },
							    { "error": "Unavailable" },
							    { "error": "DeviceMessageRateExceeded" },
							    { "error": "InternalServerError" },
							    { "error": "Unavailable" }
	                      ]
					}');

        $downstreamResponse = new DownstreamResponse($response, $tokens);

        $this->assertEquals(0, $downstreamResponse->numberSuccess());
        $this->assertEquals(6, $downstreamResponse->numberFailure());
        $this->assertEquals(0, $downstreamResponse->numberModification());

        // Unavailable is not an error caused by the token validity. it don't need to be deleted$
        $this->assertCount(0, $downstreamResponse->tokensToModify());
        $this->assertCount(0, $downstreamResponse->tokensToDelete());
        $this->assertCount(6, $downstreamResponse->tokensToRetry());

        $this->assertEquals($tokens[ 0 ], $downstreamResponse->tokensToRetry()[ 0 ]);
        $this->assertEquals($tokens[ 1 ], $downstreamResponse->tokensToRetry()[ 1 ]);
        $this->assertEquals($tokens[ 2 ], $downstreamResponse->tokensToRetry()[ 2 ]);
        $this->assertEquals($tokens[ 3 ], $downstreamResponse->tokensToRetry()[ 3 ]);
        $this->assertEquals($tokens[ 4 ], $downstreamResponse->tokensToRetry()[ 4 ]);
        $this->assertEquals($tokens[ 5 ], $downstreamResponse->tokensToRetry()[ 5 ]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_mixed_response()
    {
        $tokens = [
            'first_token',
            'second_token',
            'third_token',
            'fourth_token',
            'fifth_token',
            'sixth_token',
        ];

        $response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 3,
						  "failure": 3,
						  "canonical_ids": 1,
						  "results": [
							    { "message_id": "1:0408" },
							    { "error": "Unavailable" },
							    { "error": "InvalidRegistration" },
							    { "message_id": "1:1516" },
							    { "message_id": "1:2342", "registration_id": "32" },
							    { "error": "NotRegistered"}
	                      ]
					}');

        $downstreamResponse = new DownstreamResponse($response, $tokens);

        $this->assertEquals(3, $downstreamResponse->numberSuccess());
        $this->assertEquals(3, $downstreamResponse->numberFailure());
        $this->assertEquals(1, $downstreamResponse->numberModification());

        // Unavailable is not an error caused by the token validity. it don't need to be deleted
        $this->assertCount(2, $downstreamResponse->tokensToDelete());
        $this->assertCount(1, $downstreamResponse->tokensToModify());

        $this->assertEquals($tokens[ 2 ], $downstreamResponse->tokensToDelete()[ 0 ]);
        $this->assertEquals($tokens[ 5 ], $downstreamResponse->tokensToDelete()[ 1 ]);

        $this->assertTrue(array_key_exists($tokens[ 4 ], $downstreamResponse->tokensToModify()));
        $this->assertEquals('32', $downstreamResponse->tokensToModify()[ $tokens[ 4 ] ]);
    }

    /**
     * @test
     */
    public function it_construct_a_response_with_multiples_response()
    {
        $tokens = [
            'first_token',
            'second_token',
            'third_token',
            'fourth_token',
            'fifth_token',
            'sixth_token',
            'seventh_token',
        ];

        $tokens1 = [
            'first_1_token',
            'second_1_token',
            'third_1_token',
            'fourth_1_token',
            'fifth_1_token',
            'sixth_1_token',
            'seventh_1_token',
        ];

        $response = new Response(200, [], '{ 
						  "multicast_id": 216,
						  "success": 3,
						  "failure": 3,
						  "canonical_ids": 1,
						  "results": [
							    { "message_id": "1:0408" },
							    { "error": "Unavailable" },
							    { "error": "InvalidRegistration" },
							    { "message_id": "1:1516" },
							    { "message_id": "1:2342", "registration_id": "32" },
							    { "error": "NotRegistered"},
							    { "error": "MessageTooBig"}
	                      ]
					}');

        $downstreamResponse = new DownstreamResponse($response, $tokens);
        $downstreamResponse1 = new DownstreamResponse($response, $tokens1);

        $downstreamResponse->merge($downstreamResponse1);

        $this->assertEquals(6, $downstreamResponse->numberSuccess());
        $this->assertEquals(6, $downstreamResponse->numberFailure());
        $this->assertEquals(2, $downstreamResponse->numberModification());

        // Unavailable is not an error caused by the token validity. it don't need to be deleted
        $this->assertCount(4, $downstreamResponse->tokensToDelete());
        $this->assertCount(2, $downstreamResponse->tokensToModify());
        $this->assertCount(2, $downstreamResponse->tokensWithError());

        $this->assertEquals($tokens[ 2 ], $downstreamResponse->tokensToDelete()[ 0 ]);
        $this->assertEquals($tokens1[ 2 ], $downstreamResponse->tokensToDelete()[ 2 ]);
        $this->assertEquals($tokens[ 5 ], $downstreamResponse->tokensToDelete()[ 1 ]);
        $this->assertEquals($tokens1[ 5 ], $downstreamResponse->tokensToDelete()[ 3 ]);

        $this->assertCount(2, $downstreamResponse->tokensToRetry());

        $this->assertEquals('MessageTooBig', $downstreamResponse->tokensWithError()[$tokens[6]]);
        $this->assertEquals('MessageTooBig', $downstreamResponse->tokensWithError()[$tokens1[6]]);
    }
}
