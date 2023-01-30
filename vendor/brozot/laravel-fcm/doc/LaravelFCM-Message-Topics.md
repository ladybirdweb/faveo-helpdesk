LaravelFCM\Message\Topics
===============

Class Topics

Create topic or a topic condition


* Class name: Topics
* Namespace: LaravelFCM\Message







Methods
-------


### topic

    \LaravelFCM\Message\Topics LaravelFCM\Message\Topics::topic(string $first)

Add a topic, this method should be called before any conditional topic



* Visibility: **public**


#### Arguments
* $first **string** - &lt;p&gt;topicName&lt;/p&gt;



### orTopic

    \LaravelFCM\Message\Topics LaravelFCM\Message\Topics::orTopic(string|\Closure $first)

Add a or condition to the precedent topic set

Parenthesis is a closure

Equivalent of this: **'TopicA' in topic' || 'TopicB' in topics**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->orTopic('TopicB');
```

Equivalent of this: **'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->andTopic(function($condition) {
                     $condition->topic('TopicB')->orTopic('TopicC');
         });
```

> Note: Only two operators per expression are supported by fcm

* Visibility: **public**


#### Arguments
* $first **string|Closure** - &lt;p&gt;topicName or closure&lt;/p&gt;



### andTopic

    \LaravelFCM\Message\Topics LaravelFCM\Message\Topics::andTopic(string|\Closure $first)

Add a and condition to the precedent topic set

Parenthesis is a closure

Equivalent of this: **'TopicA' in topic' && 'TopicB' in topics**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->anTopic('TopicB');
```

Equivalent of this: **'TopicA' in topics || ('TopicB' in topics && 'TopicC' in topics)**

```
         $topic = new Topics();
         $topic->topic('TopicA')
               ->orTopic(function($condition) {
                     $condition->topic('TopicB')->AndTopic('TopicC');
         });
```

> Note: Only two operators per expression are supported by fcm

* Visibility: **public**


#### Arguments
* $first **string|Closure** - &lt;p&gt;topicName or closure&lt;/p&gt;



### build

    array|string LaravelFCM\Message\Topics::build()

Transform to array



* Visibility: **public**




### hasOnlyOneTopic

    boolean LaravelFCM\Message\Topics::hasOnlyOneTopic()

Check if only one topic was set



* Visibility: **public**



