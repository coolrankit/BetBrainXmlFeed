<?php
CREATE TABLE `SubscribeResponse` (
`subscriptionId` BIGINT NOT NULL ,
`dated` TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY ( `subscriptionId` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_subscriptions` (
`id` BIGINT NOT NULL AUTO_INCREMENT ,
`subscriptionId` BIGINT NOT NULL ,
`dated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`isDumpComplete` BOOL NOT NULL ,
`isActive` BOOL NOT NULL DEFAULT '1',
`isLocked` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_errors` (
`id` BIGINT NOT NULL ,
`dated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`request` TEXT NOT NULL ,
`code` INT NOT NULL ,
`message` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Sport` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`parentId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Currency` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`code` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_LocationType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasCode` BOOL NOT NULL ,
`codeDescription` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Location` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`name` TEXT NOT NULL ,
`code` TEXT NOT NULL ,
`isHistoric` BOOL NOT NULL ,
`url` TEXT NOT NULL ,
`note` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_LocationRelationType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_LocationRelation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`fromLocationId` BIGINT NOT NULL ,
`toLocationId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Provider` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`locationId` BIGINT NOT NULL ,
`url` TEXT NOT NULL ,
`isBookmaker` BOOL NOT NULL ,
`isBettingExchange` BOOL NOT NULL ,
`bettingCommissionVACs` DECIMAL (10,2) NOT NULL ,
`includeBettingVACs` BOOL NOT NULL ,
`isLiveOddsApproved` BOOL NOT NULL ,
`isNewsSource` BOOL NOT NULL ,
`isEnabled` BOOL NOT NULL ,
`note` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_BettingType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ParticipantType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`isIndividual` BOOL NOT NULL ,
`hasName` BOOL NOT NULL ,
`hasFirstName` BOOL NOT NULL ,
`hasLastName` BOOL NOT NULL ,
`hasIsMale` BOOL NOT NULL ,
`hasBirthTime` BOOL NOT NULL ,
`hasNationalityId` BOOL NOT NULL ,
`hasRetirementTime` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ParticipantRole` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`isPrimary` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Participant` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`name` TEXT NOT NULL ,
`firstName` TEXT NOT NULL ,
`lastName` TEXT NOT NULL ,
`isMale` BOOL NOT NULL ,
`birthTime` DATETIME NOT NULL ,
`countryId` BIGINT NOT NULL ,
`url` TEXT NOT NULL ,
`retirementTime` DATETIME NOT NULL ,
`lastEventParticipationTime` DATETIME NOT NULL ,
`note` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ParticipantUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`participantId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventPart` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`parentId` BIGINT NOT NULL ,
`orderNum` INT NOT NULL ,
`isDrawPossible` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventTemplate` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
`url` TEXT NOT NULL ,
`venueId` BIGINT NOT NULL ,
`rootPartId` BIGINT NOT NULL ,
`note` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Event` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`isComplete` BOOL NOT NULL ,
`typeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
`templateId` BIGINT NOT NULL ,
`promotionId` BIGINT NOT NULL ,
`parentId` BIGINT NOT NULL ,
`parentPartId` BIGINT NOT NULL ,
`name` TEXT NOT NULL ,
`startTime` DATETIME NOT NULL ,
`endTime` DATETIME NOT NULL ,
`deleteTimeOffset` BIGINT NOT NULL ,
`venueId` BIGINT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`hasLiveStatus` BOOL NOT NULL ,
`rootPartId` BIGINT NOT NULL ,
`currentPartId` BIGINT NOT NULL ,
`url` TEXT NOT NULL ,
`popularity` INT NOT NULL ,
`note` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventPartDefaultUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`parentEventId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
`rootPartId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EntityType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EntityPropertyType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EntityProperty` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`entityTypeId` BIGINT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantRelation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`participantId` BIGINT NOT NULL ,
`participantRoleId` BIGINT NOT NULL ,
`parentParticipantId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Source` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`collectorId` BIGINT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`sourceKey` TEXT NOT NULL ,
`lastCollectedTime` DATETIME NOT NULL ,
`lastUpdateTime` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ParticipantRelationType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamParticipantRoleId` BOOL NOT NULL ,
`paramParticipantRoleIdDescription` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ParticipantRelation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`fromParticipantId` BIGINT NOT NULL ,
`toParticipantId` BIGINT NOT NULL ,
`startTime` DATETIME NOT NULL ,
`endTime` DATETIME NOT NULL ,
`paramParticipantRoleId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ProviderEventRelation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`startTime` DATETIME NOT NULL ,
`endTime` DATETIME NOT NULL ,
`timeQualityRank` INT NOT NULL ,
`offersLiveOdds` BOOL NOT NULL ,
`offersLiveTV` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomeStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomeType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamFloat1` BOOL NOT NULL ,
`paramFloat1Description` TEXT NOT NULL ,
`hasParamFloat2` BOOL NOT NULL ,
`paramFloat2Description` TEXT NOT NULL ,
`hasParamFloat3` BOOL NOT NULL ,
`paramFloat3Description` TEXT NOT NULL ,
`hasParamBoolean1` BOOL NOT NULL ,
`paramBoolean1Description` TEXT NOT NULL ,
`hasParamString1` BOOL NOT NULL ,
`paramString1Description` TEXT NOT NULL ,
`paramString1PossibleValues` TEXT NOT NULL ,
`hasParamParticipantId1` BOOL NOT NULL ,
`paramParticipantId1Description` TEXT NOT NULL ,
`paramParticipant1MustBePrimary` BOOL NOT NULL ,
`paramParticipant1MustBeRoot` BOOL NOT NULL ,
`paramParticipant1MustHaveRoleId` BIGINT NOT NULL ,
`hasParamParticipantId2` BOOL NOT NULL ,
`paramParticipantId2Description` TEXT NOT NULL ,
`paramParticipant2MustBePrimary` BOOL NOT NULL ,
`paramParticipant2MustBeRoot` BOOL NOT NULL ,
`paramParticipant2MustHaveRoleId` BIGINT NOT NULL ,
`hasParamParticipantId3` BOOL NOT NULL ,
`paramParticipantId3Description` TEXT NOT NULL ,
`paramParticipant3MustBePrimary` BOOL NOT NULL ,
`paramParticipant3MustBeRoot` BOOL NOT NULL ,
`paramParticipant3MustHaveRoleId` BIGINT NOT NULL ,
`hasParamEventPartId1` BOOL NOT NULL ,
`paramEventPartId1Description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomeTypeBettingTypeRelation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`outcomeTypeId` BIGINT NOT NULL ,
`bettingTypeId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_BettingOfferStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`isAvailable` BOOL NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Outcome` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`isNegation` BOOL NOT NULL ,
`statusId` BIGINT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`paramFloat1` DECIMAL (10,2) NOT NULL ,
`paramFloat2` DECIMAL (10,2) NOT NULL ,
`paramFloat3` DECIMAL (10,2) NOT NULL ,
`paramBoolean1` BOOL NOT NULL ,
`paramString1` TEXT NOT NULL ,
`paramParticipantId1` BIGINT NOT NULL ,
`paramParticipantId2` BIGINT NOT NULL ,
`paramParticipantId3` BIGINT NOT NULL ,
`paramEventPartId1` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_BettingOffer` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`sourceId` BIGINT NOT NULL ,
`outcomeId` BIGINT NOT NULL ,
`bettingTypeId` BIGINT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`isLive` BOOL NOT NULL ,
`odds` DECIMAL (10,2) NOT NULL ,
`multiplicity` INT NOT NULL ,
`volume` DECIMAL (10,2) NOT NULL ,
`volumeCurrencyId` BIGINT NOT NULL ,
`couponKey` TEXT NOT NULL ,
`slotNum` INT NOT NULL ,
`lastChangedTime` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_BettingTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`bettingTypeId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EntityPropertyValue` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`entityProperyId` BIGINT NOT NULL ,
`entityId` BIGINT NOT NULL ,
`value` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventAction` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`paramFloat1` DECIMAL (10,2) NOT NULL ,
`paramParticipantId1` BIGINT NOT NULL ,
`paramParticipantId2` BIGINT NOT NULL ,
`sourceId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
`minPrimaryParticipantTimeBetweenEvents` BIGINT NOT NULL ,
`minEventDuration` BIGINT NOT NULL ,
`maxEventDuration` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantRestriction` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`participantTypeId` BIGINT NOT NULL ,
`participantIsMale` BOOL NOT NULL ,
`participantMinAge` INT NOT NULL ,
`participantMaxAge` INT NOT NULL ,
`participantPartOfLocationId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventActionTypeId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`isAvailable` BOOL NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamParticipantId1` BOOL NOT NULL ,
`paramParticipantId1Description` TEXT NOT NULL ,
`hasParamParticipantId2` BOOL NOT NULL ,
`paramParticipantId2Description` TEXT NOT NULL ,
`hasParamFloat1` BOOL NOT NULL ,
`paramFloat1Description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionDetail` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`eventActionId` BIGINT NOT NULL ,
`paramFloat1` DECIMAL (10,2) NOT NULL ,
`paramFloat2` DECIMAL (10,2) NOT NULL ,
`paramParticipantId1` BIGINT NOT NULL ,
`paramString1` TEXT NOT NULL ,
`paramBoolean1` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionDetailStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`isAvailable` BOOL NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionDetailType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamFloat1` BOOL NOT NULL ,
`paramFloat1Description` TEXT NOT NULL ,
`hasParamFloat2` BOOL NOT NULL ,
`paramFloat2Description` TEXT NOT NULL ,
`hasParamParticipantId1` BOOL NOT NULL ,
`paramParticipantId1Description` TEXT NOT NULL ,
`hasParamString1` BOOL NOT NULL ,
`paramString1Description` TEXT NOT NULL ,
`paramString1PossibleValues` TEXT NOT NULL ,
`hasParamBoolean1` BOOL NOT NULL ,
`paramBoolean1Description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventActionDetailTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventActionDetailTypeId` BIGINT NOT NULL ,
`eventActionTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventInfo` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`sourceId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`paramFloat1` DECIMAL (10,2) NOT NULL ,
`paramFloat2` DECIMAL (10,2) NOT NULL ,
`paramParticipantId1` BIGINT NOT NULL ,
`paramParticipantId2` BIGINT NOT NULL ,
`paramEventPartId1` BIGINT NOT NULL ,
`paramString1` TEXT NOT NULL ,
`paramBoolean1` BOOL NOT NULL ,
`paramEventStatusId1` BIGINT NOT NULL ,
`paramTime1` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventInfoStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`isAvailable` BOOL NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventInfoType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamFloat1` BOOL NOT NULL ,
`paramFloat1Description` TEXT NOT NULL ,
`hasParamFloat2` BOOL NOT NULL ,
`paramFloat2Description` TEXT NOT NULL ,
`hasParamParticipantId1` BOOL NOT NULL ,
`paramParticipantId1Description` TEXT NOT NULL ,
`hasParamParticipantId2` BOOL NOT NULL ,
`paramParticipantId2Description` TEXT NOT NULL ,
`hasParamEventPartId1` BOOL NOT NULL ,
`paramEventPartId1Description` TEXT NOT NULL ,
`hasParamString1` BOOL NOT NULL ,
`paramString1Description` TEXT NOT NULL ,
`paramString1PossibleValues` TEXT NOT NULL ,
`hasParamBoolean1` BOOL NOT NULL ,
`paramBoolean1Description` TEXT NOT NULL ,
`hasParamEventStatusId1` BOOL NOT NULL ,
`paramEventStatusId1Description` TEXT NOT NULL ,
`hasParamTime1` BOOL NOT NULL ,
`paramTime1Description` TEXT NOT NULL ,
`paramParticipantIdsMustBeOrdered` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventInfoTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventInfoTypeId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfo` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`sourceId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`participantId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`isAvailable` BOOL NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventParticipantInfoTypeId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoDetail` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`statusId` BIGINT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`eventParticipantInfoId` BIGINT NOT NULL ,
`paramFloat1` DECIMAL (10,2) NOT NULL ,
`paramParticipantId1` BIGINT NOT NULL ,
`paramBoolean1` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoDetailStatus` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`isAvailable` BOOL NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoDetailType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamFloat1` BOOL NOT NULL ,
`paramFloat1Description` TEXT NOT NULL ,
`hasParamParticipantId1` BOOL NOT NULL ,
`paramParticipantId1Description` TEXT NOT NULL ,
`hasParamBoolean1` BOOL NOT NULL ,
`paramBoolean1Description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_EventParticipantInfoDetailTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`eventParticipantInfoDetailTypeId` BOOL NOT NULL ,
`eventParticipantInfoTypeId` BOOL NOT NULL ,
`sportId` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ParticipantTypeRoleUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`participantTypeId` BIGINT NOT NULL ,
`participantRoleId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomePart` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`outcomePartitionId` BIGINT NOT NULL ,
`outcomeId` BIGINT NOT NULL ,
`probability` DECIMAL (10,2) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomePartition` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`isComplete` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_Market` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`eventId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`bettingTypeId` BIGINT NOT NULL ,
`numberOfOutcomes` INT NOT NULL ,
`isComplete` BOOL NOT NULL ,
`isClosed` BOOL NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_MarketOutcomeRelation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`marketId` BIGINT NOT NULL ,
`outcomeId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomeTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`outcomeTypeId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomeValidation` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`outcomeTypeId` BIGINT NOT NULL ,
`eventTypeId` BIGINT NOT NULL ,
`eventPartId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
`paramString1` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_OutcomeValidationType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamString1` BOOL NOT NULL ,
`paramString1Description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_SureBet` (
`id` BIGINT NOT NULL ,
`bettingOfferIds` BOOL NOT NULL ,
`profit` DECIMAL (10,2) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ValueBet` (
`id` BIGINT NOT NULL ,
`bettingOfferId` BIGINT NOT NULL ,
`value` DECIMAL (10,2) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_LocationTypeUsage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`locationTypeId` BIGINT NOT NULL ,
`sportId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_SystemMessageType` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`hasParamLong1` BOOL NOT NULL ,
`paramLong1Description` TEXT NOT NULL ,
`hasParamTime1` BOOL NOT NULL ,
`paramTime1Description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_SystemMessage` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`typeId` BIGINT NOT NULL ,
`description` TEXT NOT NULL ,
`createdTime` DATETIME NOT NULL ,
`paramLong1` BIGINT NOT NULL ,
`paramTime1` DATETIME NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

CREATE TABLE `fd_ProviderEntityMapping` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`providerId` BIGINT NOT NULL ,
`providerEntityTypeId` TEXT NOT NULL ,
`providerEntityId` TEXT NOT NULL ,
`entityTypeId` BIGINT NOT NULL ,
`entityId` BIGINT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;



`` INT NOT NULL ,
`` BIGINT NOT NULL ,
`` BOOL NOT NULL ,
`` TEXT NOT NULL ,
`` DATETIME NOT NULL ,
`` DECIMAL (10,2) NOT NULL ,
CREATE TABLE `fd_` (
`id` BIGINT NOT NULL ,
`version` INT NOT NULL ,
`name` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

?>
