<?php

if (!(version_compare(PHP_VERSION, '5.3') >= 0)) {
    throw new Exception('Podio PHP library requires PHP 5.3 or higher.');
}

require_once 'lib/Podio.php';
require_once 'lib/PodioResponse.php';
require_once 'lib/PodioOAuth.php';
require_once 'lib/PodioError.php';
require_once 'lib/PodioCollection.php';
require_once 'lib/PodioObject.php';
require_once 'lib/PodioLogger.php';

require_once 'models/PodioFieldCollection.php'; // Included first because other models inherit from this
require_once 'models/PodioAction.php';
require_once 'models/PodioActivity.php';
require_once 'models/PodioApp.php';
require_once 'models/PodioAppField.php';
require_once 'models/PodioAppFieldCollection.php';
require_once 'models/PodioAppMarketShare.php';
require_once 'models/PodioBatch.php';
require_once 'models/PodioByLine.php';
require_once 'models/PodioCalendarEvent.php';
require_once 'models/PodioCalendarMute.php';
require_once 'models/PodioComment.php';
require_once 'models/PodioContact.php';
require_once 'models/PodioConversation.php';
require_once 'models/PodioConversationMessage.php';
require_once 'models/PodioConversationParticipant.php';
require_once 'models/PodioEmbed.php';
require_once 'models/PodioFile.php';
require_once 'models/PodioFlow.php';
require_once 'models/PodioForm.php';
require_once 'models/PodioGrant.php';
require_once 'models/PodioHook.php';
require_once 'models/PodioImporter.php';
require_once 'models/PodioIntegration.php';
require_once 'models/PodioItem.php';
require_once 'models/PodioItemCollection.php';
require_once 'models/PodioItemDiff.php';
require_once 'models/PodioItemField.php';
require_once 'models/PodioItemFieldCollection.php';
require_once 'models/PodioItemRevision.php';
require_once 'models/PodioLinkedAccountData.php';
require_once 'models/PodioNotification.php';
require_once 'models/PodioNotificationContext.php';
require_once 'models/PodioNotificationGroup.php';
require_once 'models/PodioOrganization.php';
require_once 'models/PodioOrganizationMember.php';
require_once 'models/PodioQuestion.php';
require_once 'models/PodioQuestionAnswer.php';
require_once 'models/PodioQuestionOption.php';
require_once 'models/PodioRating.php';
require_once 'models/PodioRecurrence.php';
require_once 'models/PodioReference.php';
require_once 'models/PodioReminder.php';
require_once 'models/PodioSearchResult.php';
require_once 'models/PodioSpace.php';
require_once 'models/PodioSpaceMember.php';
require_once 'models/PodioStatus.php';
require_once 'models/PodioStreamObject.php';
require_once 'models/PodioSubscription.php';
require_once 'models/PodioTag.php';
require_once 'models/PodioTagSearch.php';
require_once 'models/PodioTask.php';
require_once 'models/PodioTaskLabel.php';
require_once 'models/PodioUser.php';
require_once 'models/PodioUserMail.php';
require_once 'models/PodioUserStatus.php';
require_once 'models/PodioVia.php';
require_once 'models/PodioView.php';
require_once 'models/PodioVoting.php';
require_once 'models/PodioWidget.php';
