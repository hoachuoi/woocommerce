<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v18/errors/query_error.proto

namespace GPBMetadata\Google\Ads\GoogleAds\V18\Errors;

class QueryError
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();
        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
1google/ads/googleads/v18/errors/query_error.protogoogle.ads.googleads.v18.errors"�
QueryErrorEnum"�

QueryError
UNSPECIFIED 
UNKNOWN
QUERY_ERROR2
BAD_ENUM_CONSTANT
BAD_ESCAPE_SEQUENCE
BAD_FIELD_NAME
BAD_LIMIT_VALUE

BAD_NUMBER
BAD_OPERATOR
BAD_PARAMETER_NAME=
BAD_PARAMETER_VALUE>$
 BAD_RESOURCE_TYPE_IN_FROM_CLAUSE-

BAD_SYMBOL
	BAD_VALUE
DATE_RANGE_TOO_WIDE$
DATE_RANGE_TOO_NARROW<
EXPECTED_AND
EXPECTED_BY-
)EXPECTED_DIMENSION_FIELD_IN_SELECT_CLAUSE%"
EXPECTED_FILTERS_ON_DATE_RANGE7
EXPECTED_FROM,
EXPECTED_LIST).
*EXPECTED_REFERENCED_FIELD_IN_SELECT_CLAUSE
EXPECTED_SELECT
EXPECTED_SINGLE_VALUE*(
$EXPECTED_VALUE_WITH_BETWEEN_OPERATOR
INVALID_DATE_FORMAT&
MISALIGNED_DATE_FOR_FILTER@
INVALID_STRING_VALUE9\'
#INVALID_VALUE_WITH_BETWEEN_OPERATOR&
"INVALID_VALUE_WITH_DURING_OPERATOR$
 INVALID_VALUE_WITH_LIKE_OPERATOR8
OPERATOR_FIELD_MISMATCH#&
"PROHIBITED_EMPTY_LIST_IN_CONDITION
PROHIBITED_ENUM_CONSTANT61
-PROHIBITED_FIELD_COMBINATION_IN_SELECT_CLAUSE\'
#PROHIBITED_FIELD_IN_ORDER_BY_CLAUSE(%
!PROHIBITED_FIELD_IN_SELECT_CLAUSE$
 PROHIBITED_FIELD_IN_WHERE_CLAUSE+
\'PROHIBITED_RESOURCE_TYPE_IN_FROM_CLAUSE+-
)PROHIBITED_RESOURCE_TYPE_IN_SELECT_CLAUSE0,
(PROHIBITED_RESOURCE_TYPE_IN_WHERE_CLAUSE:/
+PROHIBITED_METRIC_IN_SELECT_OR_WHERE_CLAUSE10
,PROHIBITED_SEGMENT_IN_SELECT_OR_WHERE_CLAUSE3<
8PROHIBITED_SEGMENT_WITH_METRIC_IN_SELECT_OR_WHERE_CLAUSE5
LIMIT_VALUE_TOO_LOW 
PROHIBITED_NEWLINE_IN_STRING(
$PROHIBITED_VALUE_COMBINATION_IN_LIST
6
2PROHIBITED_VALUE_COMBINATION_WITH_BETWEEN_OPERATOR
STRING_NOT_TERMINATED
TOO_MANY_SEGMENTS"
UNEXPECTED_END_OF_QUERY	
UNEXPECTED_FROM_CLAUSE/
UNRECOGNIZED_FIELD 
UNEXPECTED_INPUT!
REQUESTED_METRICS_FOR_MANAGER;
FILTER_HAS_TOO_MANY_VALUES?B�
#com.google.ads.googleads.v18.errorsBQueryErrorProtoPZEgoogle.golang.org/genproto/googleapis/ads/googleads/v18/errors;errors�GAA�Google.Ads.GoogleAds.V18.Errors�Google\\Ads\\GoogleAds\\V18\\Errors�#Google::Ads::GoogleAds::V18::Errorsbproto3'
        , true);
        static::$is_initialized = true;
    }
}

