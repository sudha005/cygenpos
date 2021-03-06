# Card

## Properties
Name | Getter | Setter | Type | Description | Notes
------------ | ------------- | ------------- | ------------- | ------------- | -------------
**id** | getId() | setId($value) | **string** | Unique ID for this card. Generated by Square. | [optional] 
**card_brand** | getCardBrand() | setCardBrand($value) | **string** | The card&#39;s brand (such as &#x60;VISA&#x60;). See [CardBrand](#type-cardbrand) for all possible values. | [optional] 
**last_4** | getLast4() | setLast4($value) | **string** | The last 4 digits of the card number. | [optional] 
**exp_month** | getExpMonth() | setExpMonth($value) | **int** | The expiration month of the associated card as an integer between 1 and 12. | [optional] 
**exp_year** | getExpYear() | setExpYear($value) | **int** | The four-digit year of the card&#39;s expiration date. | [optional] 
**cardholder_name** | getCardholderName() | setCardholderName($value) | **string** | The name of the cardholder. | [optional] 
**billing_address** | getBillingAddress() | setBillingAddress($value) | [**\SquareConnect\Model\Address**](Address.md) | The billing address for this card. | [optional] 
**fingerprint** | getFingerprint() | setFingerprint($value) | **string** | __Not currently set.__ Intended as a Square-assigned identifier, based  on the card number, to identify the card across multiple locations within a single application. | [optional] 

Note: All properties are protected and only accessed via getters and setters.

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

