LaravelFCM\Message\PayloadDataBuilder
===============

Class PayloadDataBuilder

Official google documentation :


* Class name: PayloadDataBuilder
* Namespace: LaravelFCM\Message







Methods
-------


### addData

    \LaravelFCM\Message\PayloadDataBuilder LaravelFCM\Message\PayloadDataBuilder::addData(array $data)

add data to existing data



* Visibility: **public**


#### Arguments
* $data **array**



### setData

    \LaravelFCM\Message\PayloadDataBuilder LaravelFCM\Message\PayloadDataBuilder::setData(array $data)

erase data with new data



* Visibility: **public**


#### Arguments
* $data **array**



### removeAllData

    mixed LaravelFCM\Message\PayloadDataBuilder::removeAllData()

Remove all data



* Visibility: **public**




### getData

    array LaravelFCM\Message\PayloadDataBuilder::getData()

return data



* Visibility: **public**




### build

    \LaravelFCM\Message\PayloadData LaravelFCM\Message\PayloadDataBuilder::build()

generate a PayloadData



* Visibility: **public**



