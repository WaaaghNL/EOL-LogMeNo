CREATE TABLE `ringcentral_counter` (
  `id` int(11) NOT NULL,
  `tenant` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `count_users` int(11) NOT NULL,
  `count_superadmins` int(11) NOT NULL,
  `proof_users` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`proof_users`))
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ringcentral_logrows`
--

CREATE TABLE `ringcentral_logrows` (
  `id` int(11) NOT NULL,
  `log_action` enum('Accept Call','Barge In Call','Call Park','Call Return','CallOut-CallMe','Calling Card','Conference Call','E911 Update','Emergency','External Application','FindMe','FollowMe','FreeSPDL','Hunting','Incoming Fax','Monitoring','Move','Outgoing Fax','Paging','Park Location','Phone Call','Phone Login','Pickup','RC Meetings','Ring Directly','RingMe','RingOut Mobile','RingOut PC','RingOut Web','Sip Forwarding','Support','Text Relay','Transfer','Unknown','VoIP Call') DEFAULT NULL,
  `log_billing_costIncluded` varchar(255) DEFAULT NULL,
  `log_billing_costPurchased` varchar(255) DEFAULT NULL,
  `log_delegate_id` varchar(255) DEFAULT NULL,
  `log_delegate_name` varchar(255) DEFAULT NULL,
  `log_deleted` varchar(5) DEFAULT NULL,
  `log_direction` enum('Inbound','Outbound') DEFAULT NULL,
  `log_duration` int(50) DEFAULT NULL COMMENT 'roundup from MS',
  `log_durationMs` int(50) DEFAULT NULL,
  `log_extension_id` varchar(255) DEFAULT NULL,
  `log_extension_uri` varchar(255) DEFAULT NULL,
  `log_from_dialerPhoneNumber` varchar(255) DEFAULT NULL,
  `log_from_device_id` varchar(50) DEFAULT NULL,
  `log_from_device_uri` varchar(255) DEFAULT NULL,
  `log_from_extensionId` varchar(255) DEFAULT NULL,
  `log_from_extensionNumber` varchar(50) DEFAULT NULL,
  `log_from_location` varchar(255) DEFAULT NULL,
  `log_from_name` varchar(255) DEFAULT NULL,
  `log_from_phoneNumber` varchar(50) DEFAULT NULL,
  `log_id` varchar(70) NOT NULL COMMENT 'id of the ringcentral call',
  `log_internalType` enum('Local','LongDistance','International','Sip','RingMe','RingOut','Usual','TollFreeNumber','VerificationNumber','Vma','LocalNumber','ImsOutgoing','ImsIncoming','Unknown') DEFAULT NULL,
  `log_lastModifiedTime` varchar(200) DEFAULT NULL,
  `log_message_id` varchar(255) DEFAULT NULL,
  `log_message_type` varchar(255) DEFAULT NULL,
  `log_message_uri` varchar(255) DEFAULT NULL,
  `log_partyId` varchar(100) DEFAULT NULL,
  `log_reason` enum('Accepted','Bad Number','Call Loop','Calls Not Accepted','Carrier is not active','Connected','Customer 611 Restricted','EDGE trunk misconfigured','Emergency Address not defined','Failed Try Again','Fax Not Received','Fax Not Sent','Fax Partially Sent','Fax Poor Line','Fax Prepare Error','Fax Save Error','Fax Send Error','Hang Up','Info 411 Restricted','Internal Call Error','Internal Error','International Disabled','International Restricted','Line Busy','Max Call Limit','No Answer','No Credit','No Digital Line','Not Answered','Number Blocked','Number Disabled','Number Not Allowed','Receive Error','Resource Error','Restricted Number','Stopped','Too Many Calls','Unknown','Wrong Number') DEFAULT NULL,
  `log_reasonDescription` varchar(255) DEFAULT NULL,
  `log_recording_contentUri` varchar(255) DEFAULT NULL,
  `log_recording_saved` enum('true','false','failed') DEFAULT NULL,
  `log_recording_type` enum('Automatic','OnDemand') DEFAULT NULL,
  `log_recording_id` varchar(255) DEFAULT NULL,
  `log_recording_uri` varchar(255) DEFAULT NULL,
  `log_result` enum('911','933','Abandoned','Accepted','Answered Not Accepted','Blocked','Busy','Call Failed','Call Failure','Call connected','Carrier is not active','Declined','EDGE trunk misconfigured','Fax Not Sent','Fax Partially Sent','Fax Poor Line','Fax Receipt Error','Fax on Demand','Hang Up','IP Phone Offline','In Progress','Internal Error','International Disabled','International Restricted','Missed','No Answer','No Calling Credit','Not Allowed','Partial Receive','Phone Login','Receive Error','Received','Rejected','Reply','Restricted Number','Send Error','Sent','Sent to Voicemail','Stopped','Suspended account','Unknown','Voicemail','Wrong Number') DEFAULT NULL,
  `log_sessionId` varchar(60) NOT NULL,
  `log_shortRecording` varchar(10) DEFAULT NULL,
  `log_sipUuidInfo` varchar(255) DEFAULT NULL,
  `log_startTime` varchar(50) NOT NULL,
  `log_telephonySessionId` varchar(200) DEFAULT NULL,
  `log_to_dialedPhoneNumber` varchar(255) DEFAULT NULL,
  `log_to_device_id` varchar(255) DEFAULT NULL,
  `log_to_device_uri` varchar(255) DEFAULT NULL,
  `log_to_extensionId` varchar(50) DEFAULT NULL,
  `log_to_extensionNumber` varchar(50) DEFAULT NULL,
  `log_to_location` varchar(255) DEFAULT NULL,
  `log_to_name` varchar(255) DEFAULT NULL,
  `log_to_phoneNumber` varchar(50) DEFAULT NULL,
  `log_transferTarget_telephonySessionId` varchar(255) DEFAULT NULL,
  `log_transferee_telephonySessionId` varchar(255) DEFAULT NULL,
  `log_transport` enum('PSTN','VoIP') DEFAULT NULL,
  `log_type` enum('Voice','Fax') NOT NULL,
  `log_uri` varchar(255) DEFAULT NULL,
  `tenantid` int(11) NOT NULL,
  `version` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ringcentral_logrows_legs`
--

CREATE TABLE `ringcentral_logrows_legs` (
  `id` int(11) NOT NULL,
  `leg_action` enum('Accept Call','Barge In Call','Call Park','Call Return','CallOut-CallMe','Calling Card','Conference Call','E911 Update','Emergency','External Application','FindMe','FollowMe','FreeSPDL','Hunting','Incoming Fax','Monitoring','Move','Outgoing Fax','Paging','Park Location','Phone Call','Phone Login','Pickup','RC Meetings','Ring Directly','RingMe','RingOut Mobile','RingOut PC','RingOut Web','Sip Forwarding','Support','Text Relay','Transfer','Unknown','VoIP Call') DEFAULT NULL,
  `leg_billing_costIncluded` varchar(255) DEFAULT NULL,
  `leg_billing_costPurchased` varchar(255) DEFAULT NULL,
  `leg_delegate_id` varchar(255) DEFAULT NULL,
  `leg_delegate_name` varchar(255) DEFAULT NULL,
  `leg_direction` enum('Inbound','Outbound') DEFAULT NULL,
  `leg_duration` int(50) DEFAULT NULL,
  `leg_durationMs` int(50) DEFAULT NULL,
  `leg_extension_id` varchar(255) DEFAULT NULL,
  `leg_extension_uri` varchar(255) DEFAULT NULL,
  `leg_from_dialerPhoneNumber` varchar(255) DEFAULT NULL,
  `leg_from_device_id` varchar(50) DEFAULT NULL,
  `leg_from_device_uri` varchar(255) DEFAULT NULL,
  `leg_from_extensionId` varchar(255) DEFAULT NULL,
  `leg_from_extensionNumber` varchar(50) DEFAULT NULL,
  `leg_from_location` varchar(255) DEFAULT NULL,
  `leg_from_name` varchar(255) DEFAULT NULL,
  `leg_from_phoneNumber` varchar(50) DEFAULT NULL,
  `leg_internalType` enum('Local','LongDistance','International','Sip','RingMe','RingOut','Usual','TollFreeNumber','VerificationNumber','Vma','LocalNumber','ImsOutgoing','ImsIncoming','Unknown') DEFAULT NULL,
  `leg_master` varchar(5) DEFAULT NULL,
  `leg_message_id` varchar(255) DEFAULT NULL,
  `leg_message_type` varchar(255) DEFAULT NULL,
  `leg_message_uri` varchar(255) DEFAULT NULL,
  `leg_partyId` varchar(100) DEFAULT NULL,
  `leg_reason` enum('Accepted','Bad Number','Call Loop','Calls Not Accepted','Carrier is not active','Connected','Customer 611 Restricted','EDGE trunk misconfigured','Emergency Address not defined','Failed Try Again','Fax Not Received','Fax Not Sent','Fax Partially Sent','Fax Poor Line','Fax Prepare Error','Fax Save Error','Fax Send Error','Hang Up','Info 411 Restricted','Internal Call Error','Internal Error','International Disabled','International Restricted','Line Busy','Max Call Limit','No Answer','No Credit','No Digital Line','Not Answered','Number Blocked','Number Disabled','Number Not Allowed','Receive Error','Resource Error','Restricted Number','Stopped','Too Many Calls','Unknown','Wrong Number') DEFAULT NULL,
  `leg_reasonDescription` varchar(255) DEFAULT NULL,
  `leg_recording_contentUri` varchar(255) DEFAULT NULL,
  `leg_recording_id` varchar(255) DEFAULT NULL,
  `leg_recording_type` varchar(255) DEFAULT NULL,
  `leg_recording_uri` varchar(255) DEFAULT NULL,
  `leg_result` enum('911','933','Abandoned','Accepted','Answered Not Accepted','Blocked','Busy','Call Failed','Call Failure','Call connected','Carrier is not active','Declined','EDGE trunk misconfigured','Fax Not Sent','Fax Partially Sent','Fax Poor Line','Fax Receipt Error','Fax on Demand','Hang Up','IP Phone Offline','In Progress','Internal Error','International Disabled','International Restricted','Missed','No Answer','No Calling Credit','Not Allowed','Partial Receive','Phone Login','Receive Error','Received','Rejected','Reply','Restricted Number','Send Error','Sent','Sent to Voicemail','Stopped','Suspended account','Unknown','Voicemail','Wrong Number') DEFAULT NULL,
  `leg_shortRecording` varchar(10) DEFAULT NULL,
  `leg_sipUuidInfo` varchar(255) DEFAULT NULL,
  `leg_startTime` varchar(50) DEFAULT NULL,
  `leg_telephonySessionId` varchar(100) DEFAULT NULL,
  `leg_to_dialedPhoneNumber` varchar(255) DEFAULT NULL,
  `leg_to_device_id` varchar(50) DEFAULT NULL,
  `leg_to_device_uri` varchar(255) DEFAULT NULL,
  `leg_to_extensionId` varchar(50) DEFAULT NULL,
  `leg_to_extensionNumber` varchar(50) DEFAULT NULL,
  `leg_to_location` varchar(255) DEFAULT NULL,
  `leg_to_name` varchar(255) DEFAULT NULL,
  `leg_to_phoneNumber` varchar(50) DEFAULT NULL,
  `leg_transferTarget_telephonySessionId` varchar(200) DEFAULT NULL,
  `leg_transferee_telephonySessionId` varchar(200) DEFAULT NULL,
  `leg_transport` enum('PSTN','VoIP') DEFAULT NULL,
  `leg_legtype` enum('SipForwarding','ServiceMinus2','ServiceMinus3','PstnToSip','Accept','FindMe','FollowMe','TestCall','FaxSent','CallBack','CallingCard','RingDirectly','RingOutWebToSubscriber','RingOutWebToCaller','SipToPstnMetered','RingOutClientToSubscriber','RingOutClientToCaller','RingMe','TransferCall','SipToPstnUnmetered','RingOutDeviceToSubscriber','RingOutDeviceToCaller','RingOutOneLegToCaller','ExtensionToExtension','CallPark','PagingServer','Hunting','OutgoingFreeSpDl','ParkLocation','ConferenceCall','MobileApp','MoveToConference','Unknown','MeetingsCall','SilentMonitoring','Monitoring','Pickup','ImsCall','JoinCall','TextRelay') NOT NULL,
  `log_id` varchar(255) NOT NULL,
  `leg_type` enum('Voice','Fax') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ringcentral_recordings`
--

CREATE TABLE `ringcentral_recordings` (
  `id` int(11) NOT NULL,
  `tenant` int(11) NOT NULL,
  `log_id` varchar(70) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(11) NOT NULL,
  `filetype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `tenantkey` varchar(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ringcentral_jwt` text NOT NULL,
  `timezone` varchar(255) NOT NULL DEFAULT 'Europe/Amsterdam',
  `maxage` int(11) NOT NULL DEFAULT 2555 COMMENT 'how long are logs stored? normal 7 years',
  `cache_logrows` int(11) DEFAULT NULL,
  `cache_recordings` int(11) DEFAULT NULL,
  `cache_days` int(11) DEFAULT NULL,
  `cache_storage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `tenantkey`, `name`, `ringcentral_jwt`, `timezone`, `maxage`, `cache_logrows`, `cache_recordings`, `cache_days`, `cache_storage`) VALUES
(1, 'KEYKEY', 'LogMeNo Productie', 'BROKENJWTKEY_ey...DUTBPfajsLQ', 'Europe/Amsterdam', 2555, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `worker_jobs`
--

CREATE TABLE `worker_jobs` (
  `id` int(11) NOT NULL,
  `tenant` int(11) NOT NULL,
  `startAfter` int(11) NOT NULL DEFAULT 0,
  `startTime` int(11) DEFAULT NULL,
  `endTime` int(11) DEFAULT NULL,
  `after` datetime DEFAULT NULL COMMENT 'Start after time',
  `start` datetime DEFAULT NULL COMMENT 'Starttime event',
  `end` datetime DEFAULT NULL COMMENT 'Stoptime event',
  `type` varchar(50) DEFAULT NULL,
  `status` enum('Pending','In Progress','Completed','Skipped','Failed','Disabled','Deleted') NOT NULL DEFAULT 'Pending' COMMENT 'Pending: Wachten op verwerken.\r\n\r\nIn Progress: Job is opgepakt en wordt op dit moment verwerkt.\r\n\r\nCompleted: Succesvol afgerond.\r\n\r\nFailed: Er zijn fouten opgetreden tijdens het verwerken van de data. Check de logs\r\n\r\nSkipped: Overgeslagen.\r\n\r\nDisabled: Tijdelijk uitgesteld voor bijvoorbeeld onderhoud. De job blijft bestaan tot de status wordt aangepast naar Pending.\r\n\r\nDeleted: When a job is no longer relevant or needs to be removed from the system, you can mark it with this status to indicate that it has been deleted. You can periodically clean up or archive deleted jobs from your database.',
  `durationMs` float(11,5) DEFAULT NULL,
  `resultDescription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

--
-- Dumping data for table `worker_jobs`
--

INSERT INTO `worker_jobs` (`id`, `tenant`, `startAfter`, `startTime`, `endTime`, `after`, `start`, `end`, `type`, `status`, `durationMs`, `resultDescription`) VALUES
(1, 1, 0, NULL, NULL, NULL, NULL, NULL, 'logs_grab', 'Pending', NULL, NULL),
(2, 1, 0, NULL, NULL, NULL, NULL, NULL, 'logs_process_v2', 'Pending', NULL, NULL),
(3, 1, 0, NULL, NULL, NULL, NULL, NULL, 'rc_stats_grab', 'Pending', NULL, NULL),
(4, 1, 0, NULL, NULL, NULL, NULL, NULL, 'rc_stats_process', 'Pending', NULL, NULL),
(5, 1, 0, NULL, NULL, NULL, NULL, NULL, 'recordings_download', 'Pending', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ringcentral_counter`
--
ALTER TABLE `ringcentral_counter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Counters_Counter_Tenant` (`tenant`);

--
-- Indexes for table `ringcentral_logrows`
--
ALTER TABLE `ringcentral_logrows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `LogID_UNIQUE` (`log_id`) USING BTREE,
  ADD KEY `Mainuser_Logrows_Tennent` (`tenantid`),
  ADD KEY `LogID_INDEX` (`log_id`) USING BTREE,
  ADD KEY `log_startTime` (`log_startTime`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `ringcentral_logrows_legs`
--
ALTER TABLE `ringcentral_logrows_legs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Logrows_Connect_Legs` (`log_id`),
  ADD KEY `startTime` (`leg_startTime`),
  ADD KEY `log_id` (`log_id`);

--
-- Indexes for table `ringcentral_recordings`
--
ALTER TABLE `ringcentral_recordings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Recordings_record_log` (`log_id`),
  ADD KEY `Recordings_record_tenant` (`tenant`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenantkey` (`tenantkey`) USING BTREE;

--
-- Indexes for table `worker_jobs`
--
ALTER TABLE `worker_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Tenant_2_Jobs_Connection` (`tenant`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ringcentral_counter`
--
ALTER TABLE `ringcentral_counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ringcentral_logrows`
--
ALTER TABLE `ringcentral_logrows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ringcentral_logrows_legs`
--
ALTER TABLE `ringcentral_logrows_legs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ringcentral_recordings`
--
ALTER TABLE `ringcentral_recordings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `worker_jobs`
--
ALTER TABLE `worker_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ringcentral_counter`
--
ALTER TABLE `ringcentral_counter`
  ADD CONSTRAINT `Tenant_2_Counter_Connection` FOREIGN KEY (`tenant`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ringcentral_logrows_legs`
--
ALTER TABLE `ringcentral_logrows_legs`
  ADD CONSTRAINT `Logs_2_Legs_Connection` FOREIGN KEY (`log_id`) REFERENCES `ringcentral_logrows` (`log_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ringcentral_recordings`
--
ALTER TABLE `ringcentral_recordings`
  ADD CONSTRAINT `Logs_2_Recordings_connection` FOREIGN KEY (`log_id`) REFERENCES `ringcentral_logrows` (`log_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Tenant_2_Recordings_Connection` FOREIGN KEY (`tenant`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `worker_jobs`
--
ALTER TABLE `worker_jobs`
  ADD CONSTRAINT `Tenant_2_Jobs_Connection` FOREIGN KEY (`tenant`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
