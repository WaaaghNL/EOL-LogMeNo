## RingLog
The archive tool to backup data from Avaya ACO end RingCentral

### What to archive
* Call logs
* Voice recordings
* Voicemails

### Timezone UTC
Alle tijden in de centrale zijn in UTC

### Purge 
* Automatisch weggooien van data
* HIPPA

### Worker
De eerste download is altijd een FSync met een maximale download van 250 items, hierbij kan een statdatum worden opgegeven.

Resultaat: max 250 resultaten, en een synctoken

ISync
Dit haalt de nieuwe regels op vanaf het moment dat de synctoken is gegenereerd met een maximaal van 250 regels


Error log: Log alle errors


### Tennent
Elke gebruiker krijgt een tennent waar een of meerdere gebruikers aan gekoppeld kunnen worden. Een tennent ID moet uniek zijn denk hierbij aan de tokens van Youtube: https://www.youtube.com/watch?v=gocwRvLhDf8&ab_channel=TomScott

Een ID kan maar 1x gebruikt worden EVER! gebruik HEX of zo


### Names
Logtopia
DialSaver
RingBuddy
RingNinja

RingInsight (.com beschikbaar)
RingDio Logs
RingDio Recordings
RingDio Contacts
Ringdio.com

### Leesvoer

https://developers.ringcentral.com/guide/voice/call-log/sync
https://developers.ringcentral.com/api-reference/Call-Log/syncAccountCallLog
https://developers.ringcentral.com/guide/voice/call-log/archival#call-log-data-retention-policies
https://developers.ringcentral.com/api-reference/Call-Log/syncAccountCallLog



## Worker
We have some workers to get things done

### Grabber
The grabber gets the logs and stores them on our servers. When the job is done the Grabber puts a job in the databse so the schedular can start the processor.

report status code of the run. Store in run log

### Remover
This job removes all old logs from our servers and from the database.

### Processor
The processor reads the files that are created by the grabber and puts it in the database. After the data is inserted in to the database the worker puts in a job to start a remover for that tenant

### Schedular
This process checks the status of the other workers and puts in a new Grabber job when the remover is done and the time is exceeded of the interval






## App
* erlang calculatie per uur
* erlang calculatie per dag
* erlang calculatie per X periode
* https://www.callcentretools.com/tools/erlang-calculator/day-planner.php




### Every function within 3 clicks
after logging in every option needs to be within 3 clicks from the homepage! there are exeptions for options that only need to be set once but never more than 5 cliks away!














## Featuers
### Exclude Phone numbers
Exclude phonenumbers from getting in the logs