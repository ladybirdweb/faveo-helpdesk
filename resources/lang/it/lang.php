<?php

return [
    /*
      |----------------------------------------------------------------------------------------
      | Authentication Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all authentication related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */

    /*
      |--------------------------------------
      |   Error
      |--------------------------------------
     */

    'success'        => 'Successo',
    'fails'          => 'Fallito',
    'alert'          => 'Allerta',
    'required-error' => 'Per favore inserire i campi richiesti',
    'invalid'        => 'Id Utente o Password sbagliate',
    /*
      |--------------------------------------
      |   Login Page
      |--------------------------------------
     */
    'Login_to_start_your_session' => 'Login per incominciare la tua sessione',
    'login'                       => 'Login',
    'remember'                    => 'Ricordami',
    'signmein'                    => 'Segnami',
    'iforgot'                     => 'Ho dimenticato la Password',
    'email_address'               => 'Indirizzo E-Mail',
    'password'                    => 'Password',
    'woops'                       => 'Whoops!',
    'theirisproblem'              => 'Ci sono problemi con ciò che hai inserito.',
    'login'                       => 'Login',
    'e-mail'                      => 'E-mail',
    'reg_new_member'              => 'Registra una nuova associazione',
    /*
      |--------------------------------------
      |   Register Page
      |--------------------------------------
     */
    'registration'                => 'Registrazione',
    'full_name'                   => 'Nome completo',
    'firstname'                   => 'Nome',
    'lastname'                    => 'Cognome',
    'profilepicture'              => 'Foto del Profilo',
    'oldpassword'                 => 'Vecchia Password',
    'newpassword'                 => 'Nuova Password',
    'retype_password'             => 'Reinserisci Password',
    'i_agree_to_the'              => 'Concordo con',
    'terms'                       => 'termini',
    'register'                    => 'Registra',
    'i_already_have_a_membership' => 'Sono già associato',
    /*
      |--------------------------------------
      |   Reset Password Page
      |--------------------------------------
     */
    'reset_password' => 'Resetta la Password',
    /*
      |--------------------------------------
      |   Forgot Password Page
      |--------------------------------------
     */
    'i_know_my_password'            => 'Conosco la mia password',
    'recover_passord'               => 'Recupera Password',
    'send_password_reset_link'      => 'Invia Link per il Reset della password',
    'enter_email_to_reset_password' => 'Inserisci E-mail per il reset della password',
    'link'                          => 'Link',
    /*
      |----------------------------------------------------------------------------------------
      | Emails Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Emails related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */
    'admin_panel' => 'Panello Amministrativo',
    /*
      |--------------------------------------
      |  Emails Create Page
      |--------------------------------------
     */
    'emails'                         => 'Emails',
    'incoming_emails'                => 'Emails In Arrivo',
    'reuired_authentication'         => 'Autenticazione Richiesta',
    'fetching_email_via_imap'        => 'Caricamento Email via IMAP',
    'create_email'                   => 'Crea Email',
    'email_address'                  => 'Indirizzo Email',
    'email_name'                     => 'Nome Email',
    'help_topic'                     => 'Argomento della Guida',
    'auto_response'                  => 'Auto Risposta',
    'host_name'                      => 'Nome Host',
    'port_number'                    => 'Numero Porta',
    'mail_box_protocol'              => 'Protocollo di Casella Mail',
    'authentication_required'        => 'Autenticazione Richiesta',
    'yes'                            => 'Si',
    'no'                             => 'No',
    'header_spoofing'                => 'Header Spoofing',
    'allow_for_this_email'           => 'Permetti per questa Email',
    'imap_config'                    => 'Configurazione IMAP',
    'email_information_and_settings' => 'Informazioni e settaggi Email',
    'incoming_email_information'     => 'Informazioni Email in entrata',
    'outgoing_email_information'     => 'Informazioni Email in uscita',
    'new_ticket_settings'            => 'Settaggi Nuovo Ticket',
    'protocol'                       => 'Protocollo',
    'fetching_protocol'              => 'Caricando Protocol',
    'transfer_protocol'              => 'Trasferendo Protocol',
    'from_name'                      => 'Da Nome',
    'add_an_email'                   => 'Aggiungi una Email',
    'edit_an_email'                  => 'Modifica una Email',
    'disable_for_this_email_address' => 'Disabilita per questo indirizzo Email ',
    /*
      |--------------------------------------
      |  Ban Emails Create Page
      |--------------------------------------
     */
    'ban_lists'  => 'Lista Ban',
    'ban_email'  => 'Email Ban',
    'banlists'   => 'Liste Ban',
    'ban_status' => 'Status Ban',
    /*
      |--------------------------------------
      |  Templates Index Page
      |--------------------------------------
     */
    'templates'       => 'Templates',
    'template_set'    => 'Template Sets',
    'create_template' => 'Crea Template',
    'edit_template'   => 'Modifica Template',
    'in_use'          => 'In Uso',
    //Template Description
    'Create ticket agent'       => 'Email di notifica che è inviata a Agente e Admin quando il ticket è creato',
    'Assign ticket'             => 'Ticket assegnato ad un agente',
    'Create ticket'             => 'Mail inviata al cliente per conferma creazione ticket',
    'Check ticket'              => 'Se un cliente vuole controllare attraverso il portale clienti un link verrà inviato al cliente.Questo link è per il cliente per vedere i dettagli del ticket co il suo numero senza loggarsi nel sistema',
    'Ticket reply agent'        => 'Una notifica è inviata ad un agente una volta che il cliente risponde al ticket',
    'Registration notification' => 'Password e nome utente sono inviati in email alla prima registrazione',
    'Reset password'            => 'Email con il link per il reset della Password',
    'Error report'              => 'Report Errori',
    'Ticket creation'           => 'Prima notifica inviata dal sistema sulla creazione del ticket al cliente',
    'Ticket reply'              => 'Una risposta fatta da un agente sul ticket,una notifica è inviata al cliente e ai collaboratori',
    'Close ticket'              => 'Mail inviata al cliente per la chiusura di un ticket',
    'Create ticket by agent'    => 'Un agente crea un ticket per il cliente a nome del cliente',
    /*
      |--------------------------------------
      |  Templates Create Page
      |--------------------------------------
     */
    'template_set_to_clone' => 'Template set da clonare',
    'language'              => 'Lingua',
    /*
      |--------------------------------------
      |  Diagnostics Page
      |--------------------------------------
     */
    'diagnostics' => 'Diagnostici',
    'from'        => 'Da',
    'to'          => 'A',
    'subject'     => 'Soggetto',
    'message'     => 'Messaggio',
    'send'        => 'Invia',
    /*
      |----------------------------------------------------------------------------------------
      | Settings Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Setting related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */

    /*
      |--------------------------------------
      |   Company Settings Page
      |--------------------------------------
     */
    'company' => 'Compagnia',
    'website' => 'Sito Web',
    'phone'   => 'Telefono',
    'address' => 'Indirizzo',
    'landing' => 'Landing Page',
    'offline' => 'Offline Page',
    'thank'   => 'Thank Page',
    'logo'    => 'Logo',
    'save'    => 'Salva',
    /*
      |--------------------------------------
      |   System Settings Page
      |--------------------------------------
     */
    'system'                => 'Sistema',
    'online'                => 'Online',
    'offline'               => 'Offline',
    'name/title'            => 'Nome/Titolo',
    'pagesize'              => 'Grandezza Pagina',
    'url'                   => 'URL',
    'default_department'    => 'Dipartimento di Default',
    'loglevel'              => 'Livello Log',
    'purglog'               => 'Ripulisci Logs',
    'nameformat'            => 'Formattazione nome',
    'timeformat'            => 'Formato Ora',
    'date'                  => 'Data',
    'dateformat'            => 'Formato Data',
    'date_time'             => 'Formato Data e Ora',
    'day_date_time'         => 'Formato Giorno,Data e Ora',
    'timezone'              => 'Fuso orario di default',
    'api'                   => 'Api',
    'api_key'               => 'Chiave Api',
    'api_key_mandatory'     => 'Chiave Api obbligatoria',
    'api_configurations'    => 'Configurazioni Api',
    'generate_key'          => 'Genera chiave',
    /*
      |--------------------------------------
      |   Email Settings Page
      |--------------------------------------
     */
    'email'                               => 'Email',
    'default_template'                    => 'Template Set di Default:',
    'default_system_email'                => 'Sistema Email di Default:',
    'default_alert_email'                 => 'Allerta Email di Default:',
    'admin_email'                         => 'indirizzo Email Amministratori:',
    'email_fetch'                         => 'Caricamento Email:',
    'enable'                              => 'Attiva',
    'default_MTA'                         => 'MTA di Default',
    'fetch_auto-corn'                     => 'Carica con auto-cron',
    'strip_quoted_reply'                  => 'Rimuovi Citazioni nella Risposta',
    'reply_separator'                     => 'Tag Separatore nella Risposta',
    'accept_all_email'                    => 'Accetta Tutte le Emails',
    'accept_email_unknown'                => 'Accetta email da utenti sconosciuti',
    'accept_email_collab'                 => 'Accetta Email Da Collaboratori',
    'automatically_and_collab_from_email' => 'Aggiungi automaticamente collaboratori dai campi email',
    'default_alert_email'                 => 'Allerta Email di Default',
    'attachments'                         => 'Allegati',
    'email_attahment_user'                => 'Email attachments to the user',
    'cron_notification'                   => 'Attiva Notifica cron',
    /*
      |--------------------------------------
      |   Ticket Settings Page
      |--------------------------------------
     */
    'ticket'                             => 'Ticket',
    'default_ticket_number_format'       => 'Default Ticket Number Format',
    'default_ticket_number_sequence'     => 'Default Ticket Number Sequence',
    'default_status'                     => 'Default Status',
    'default_priority'                   => 'Default Priority',
    'default_sla'                        => 'Default SLA',
    'default_help_topic'                 => 'Default Help Topic',
    'maximum_open_tickets'               => 'Maximum Open Tickets',
    'agent_collision_avoidance_duration' => 'Agent Collision Avoidance Duration',
    'human_verification'                 => 'Human Verification',
    'claim_on_response'                  => 'Claim on Response',
    'assigned_tickets'                   => 'Assigned Tickets',
    'answered_tickets'                   => 'Answered Tickets',
    'agent_identity_masking'             => 'Agent Identity Masking',
    'enable_HTML_ticket_thread'          => 'Enable HTML Ticket Thread',
    'allow_client_updates'               => 'Allow Client Updates',
    /*
      |--------------------------------------
      |   Access Settings Page
      |--------------------------------------
     */
    'access'                                           => 'Accesso',
    'expiration_policy'                                => 'Policy Scadenza Password',
    'allow_password_resets'                            => 'Permetti Password Reset',
    'reset_token_expiration'                           => 'Resetta Scadenza Token',
    'agent_session_timeout'                            => 'Timeout Sessione Agente',
    'bind_agent_session_IP'                            => 'Lega Sessione Agente a IP',
    'registration_required'                            => 'Registrazione Richiesta',
    'require_registration_and_login_to_create_tickets' => 'Richiede registrazione e login per creare tickets',
    'registration_method'                              => 'metodo di Registrazione',
    'user_session_timeout'                             => 'Timeout Sessione Utente',
    'client_quick_access'                              => 'Accesso Rapido per Cliente',
    /*
      |--------------------------------------
      |   Auto-Response Settings Page
      |--------------------------------------
     */
    'auto_responce'                 => 'Auto Risposta',
    'new_ticket'                    => 'Nuovo Ticket',
    'new_ticket_by_agent'           => 'Nuovo Ticket per Agente',
    'new_message'                   => 'Nuovo Messaggio',
    'submitter'                     => 'Inviato da : ',
    'send_receipt_confirmation'     => 'Invia ricevuta Conferma',
    'participants'                  => 'Partecipanti : ',
    'send_new_activity_notice'      => 'Invia nuova notifica attività',
    'overlimit_notice'              => 'Overlimit Notice',
    'email_attachments_to_the_user' => 'Invia in email allegati ad utente',
    /*
      |--------------------------------------
      |   Alert & Notice Settings Page
      |--------------------------------------
     */
    'disable'                                               => 'Disabilita',
    'admin_email_2'                                         => 'Email Amministratore',
    'alert_notices'                                         => 'Allerte & Notifiche',
    'new_ticket_alert'                                      => 'Allerta Nuovo Ticket',
    'department_manager'                                    => 'Manager Dipartimento',
    'department_members'                                    => 'Componenti del Dipartimento',
    'organization_account_manager'                          => 'Account Manager Organizzazione',
    'new_message_alert'                                     => 'Allerta Nuovo Messaggio',
    'last_respondent'                                       => 'Ultimo a Rispondere',
    'assigned_agent_team'                                   => 'Agente / Team Assegnato',
    'new_internal_note_alert'                               => 'Allerta Nuova Nota Interna',
    'ticket_assignment_alert'                               => 'Allerta Assegnamento Ticket',
    'team_lead'                                             => 'Leader del Team',
    'team_members'                                          => 'Componenti del Team',
    'ticket_transfer_alert'                                 => 'Allerta Trasferimento Ticket',
    'overdue_ticket_alert'                                  => 'Overdue Ticket Alert ',
    'system_alerts'                                         => 'Allerta di Sistema',
    'system_errors'                                         => 'Errori di Sistema',
    'SQL_errors'                                            => 'Errori SQL',
    'excessive_failed_login_attempts'                       => 'Tentativi di login falliti eccessivi',
    'system_error_reports'                                  => 'Rapporti di errori Sistema',
    'Send_app_crash_reports_to_help_Ladybird_improve_Faveo' => 'Invia segnalazioni di crash per aiutare Ladybird per migliorare Faveo',
    /*
      |------------------------------------------------
      |Language page
      |------------------------------------------------
     */
    'default'            => 'default',
    'iso-code'           => 'ISO-CODE',
    'download'           => 'Scarica',
    'upload_file'        => 'Carica un File',
    'enter_iso-code'     => 'Inserisci ISO-CODE',
    'eg.'                => 'Esempio',
    'for'                => 'per',
    'english'            => 'English',
    'language-name'      => 'Nome lingua',
    'file'               => 'File',
    'read-more'          => 'Leggi di più.',
    'enable_lang'        => 'Attivalo.',
    'add-lang-package'   => 'Aggiungi nuovo pacchetto lingua',
    'package_exist'      => 'Pacchetto già esistente.',
    'iso-code-error'     => 'Errore nel codice iso. inserire codice corretto.',
    'zipp-error'         => 'Errore nel file zip. Lo zip deve contenere solo file lingua php.',
    'upload-success'     => 'Caricato con successo.',
    'file-error'         => 'Errore nel file file non valido.',
    'delete-success'     => 'Pacchetto Lingua cancellato con successo.',
    'lang-doesnot-exist' => 'Pacchetto Lingua non esistente.',
    'active-lang-error'  => 'Pacchetto Lingua non cancellabile quando attivo.',
    'language-error'     => 'Pacchetto Lingua non trovabile nella cartella lingua.',
    /*
      |----------------------------------------------------------------------------------------
      | Manage Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Manage related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */
    'manage' => 'gestione',
    /*
      |--------------------------------------
      |  Help Topic index Page
      |--------------------------------------
     */
    'help_topics'       => 'Help Topics',
    'topic'             => 'Argomento',
    'type'              => 'Tipo',
    'priority'          => 'Priorità',
    'last_updated'      => 'Ultimo aggiornamento',
    'create_help_topic' => 'Crea Argomento Guida',
    'action'            => 'Azione',
    /*
      |--------------------------------------
      |  Help Topic Create Page
      |--------------------------------------
     */
    'active'               => 'Attivo',
    'disabled'             => 'Disabilitato',
    'public'               => 'Pubblico',
    'private'              => 'Privato',
    'parent_topic'         => 'Argomento principale',
    'Custom_form'          => 'Form Personalizzato',
    'SLA_plan'             => 'SLA Plan',
    'auto_assign'          => 'Auto assegna',
    'auto_respons'         => 'Auto Risposta',
    'ticket_number_format' => 'Formato numero Ticket',
    'system_default'       => 'Default di Sistema',
    'custom'               => 'Personalizzato',
    'internal_notes'       => 'Note Interne',
    /*
      |--------------------------------------
      |  SLA plan Index Page
      |--------------------------------------
     */
    'sla_plans'    => 'SLA Plans',
    'create_SLA'   => 'Create a SLA',
    'grace_period' => 'Grace Period',
    'added_date'   => 'Data Aggiunta',
    /*
      |--------------------------------------
      |  SLA plan Create Page
      |--------------------------------------
     */
    'transient'            => 'Transient',
    'ticket_overdue_alert' => 'Ticket Overdue Alerts',
    /*
      |--------------------------------------
      |  Form Create Page
      |--------------------------------------
     */
    'title'                                 => 'Titolo',
    'instruction'                           => 'Istruzione',
    'label'                                 => 'Etichetta',
    'visibility'                            => 'Visibilità',
    'variable'                              => 'Variabile',
    'create_form'                           => 'Crea Form',
    'forms'                                 => 'Forms',
    'form_name'                             => 'Nome del Form',
    'view_this_form'                        => 'Vedi questo Form',
    'delete_from'                           => 'Cancella Form',
    'are_you_sure_you_want_to_delete'       => 'Sicuro di voler Cancellare',
    'close'                                 => 'Chiudi',
    'instructions'                          => 'Istruzioni',
    'instructions_on_creating_form'         => "Seleziona il tipo di campo che vuoi aggiungere al form sottostante e clicca sul menu a cascata 'Tipo'. Non dimenticare di settare le opzioni del campo se il tipo è selezionato,checkbox radio...Separate ogni opzione con una virgola . Dopo aver finito di creare il form, potete salvare il form cliccando il pulsante Salva Form",
    'form_properties'                       => 'Proprietà Form',
    'adding_fields'                         => 'Aggiungendo Campi',
    'click_add_fields_button_to_add_fields' => "Clicca il pulsante <b>'Aggiungi Campi'</b> per aggiungere campi",
    'add_fields'                            => 'Aggiungi Campi',
    'save_form'                             => 'Salva Form',
    'label'                                 => 'Etichetta',
    'name'                                  => 'Nome',
    'type'                                  => 'Tipo',
    'values(selected_fields)'               => 'Valori(Campi Selezionati)',
    'required'                              => 'Richiesto',
    'Action'                                => 'Azione',
    'remove'                                => 'Rimuovi',
    /*
      |----------------------------------------------------------------------------------------
      | Theme Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Theme related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */
    'themes' => 'Temi',
    /*
      |--------------------------------------
      |  Footer Pages
      |--------------------------------------
     */
    'footer'  => 'Footer',
    'footer1' => 'Footer1',
    'footer2' => 'Footer2',
    'footer3' => 'Footer3',
    'footer4' => 'Footer4',
     /*
      |--------------------------------------
      |  Custom alert box
      |--------------------------------------
     */
    'ok'                     => 'Ok',
    'cancel'                 => 'Cancella',
    'select-ticket'          => 'Per favore seleziona tickets.',
    'confirm'                => 'Sei sicuro?',
    'delete-tickets'         => 'Cancella Tickets',
    'close-tickets'          => 'Chiudi Tickets',
    'open-tickets'           => 'Apri Tickets',

    /*
      |----------------------------------------------------------------------------------------
      | Staff Pages [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Staff related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */
    'are_you_sure' => 'Are you sure',
    'staffs'       => 'Staffs',
    'name'         => 'Nome',
    'user_name'    => 'Nome Utente',
    'status'       => 'Status',
    'group'        => 'Gruppo',
    'department'   => 'Dipartimento',
    'created'      => 'Creato',
    'lastlogin'    => 'Ultimo Login',
    'createagent'  => 'Crea Un Agente',
    'delete'       => 'Cancella',
    'agents'       => 'Agenti',
    'create'       => 'Crea',
    'edit'         => 'modifica',
    'departments'  => 'Dipartimenti',
    'groups'       => 'Gruppi',
    /*
      |--------------------------------------
      |  Staff Create Page
      |--------------------------------------
     */
    'create_agent'           => 'Crea Agente',
    'first_name'             => 'Nome',
    'last_name'              => 'Cognome',
    'mobile_number'          => 'Numero Mobile',
    'agent_signature'        => 'Firma Agente',
    'account_status_setting' => 'Status Account & Settaggi',
    'account_type'           => 'Tipo Account',
    'admin'                  => 'Admin',
    'agent'                  => 'Agente',
    'account_status'         => 'Status Account',
    'locked'                 => 'Bloccato',
    'assigned_group'         => 'Gruppo Assegnato',
    'primary_department'     => 'Dipartimento Principale',
    'agent_time_zone'        => 'Agent Time Zone',
    'day_light_saving'       => 'Day Light Saving',
    'limit_access'           => 'Limita Accesso',
    'directory_listing'      => 'Directory Listing',
    'vocation_mode'          => 'Vocation Mode',
    'assigned_team'          => 'Team Assegnato',
    /*
      |--------------------------------------
      |  Department Create Page
      |--------------------------------------
     */
    'create_department'                                => 'Crea Dipartimento',
    'manager'                                          => 'Manager',
    'ticket_assignment'                                => 'Assegnamento Ticket ',
    'restrict_ticket_assignment_to_department_members' => 'Restrict ticket assignment to department members',
    'outgoing_emails'                                  => 'Emails in uscita',
    'outgoing_email'                                   => 'Email in uscita',
    'template_set'                                     => 'Template Set',
    'auto_responding_settings'                         => 'Settaggi Auto-Risposta',
    'disable_for_this_department'                      => 'Disattiva per questo dipartimento',
    'auto_response_email'                              => 'Email Auto-Risposta',
    'recipient'                                        => 'Recipient',
    'group_access'                                     => 'Accesso Gruppo',
    'department_signature'                             => 'Firma Dipartimento',
    /*
      |--------------------------------------
      |  Team Create Page
      |--------------------------------------
     */
    'create_team'           => 'Crea Team',
    'team_lead'             => 'Team Lead',
    'assignment_alert'      => 'Allerta Assegnamento',
    'disable_for_this_team' => 'Disattiva per questo team',
    'teams'                 => 'Teams',
    /*
      |--------------------------------------
      |  Group Create Page
      |--------------------------------------
     */
    'create_group'         => 'Crea Gruppo',
    'goups'                => 'Gruppi',
    'can_create_ticket'    => 'Può creare ticket',
    'can_edit_ticket'      => 'Può editare ticket',
    'can_post_ticket'      => 'Può postare Ticket',
    'can_close_ticket'     => 'Può chiudere un ticket ',
    'can_assign_ticket'    => 'Può assegnare ticket',
    'can_transfer_ticket'  => 'Può trasferire ticket',
    'can_delete_ticket'    => 'Può cancellare ticket',
    'can_ban_emails'       => 'Può bannare le email',
    'can_manage_premade'   => 'Può Manage premade',
    'can_manage_FAQ'       => 'Può gestire le FAQ',
    'can_view_agent_stats' => 'Può visualizzare le stats per agente',
    'department_access'    => 'Accesso Dipartimenti ',
    'admin_notes'          => 'Note Admin',
    'group_members'        => 'Componenti del Gruppo',
    'group_name'           => 'Nome Gruppo',
    /*
      |--------------------------------------
      |  SMTP Page
      |--------------------------------------
     */
    'driver'     => 'Driver',
    'smtp'       => 'SMTP',
    'host'       => 'Host',
    'port'       => 'Porta',
    'encryption' => 'Criptazione',
    /*
      |----------------------------------------------------------------------------------------
      | Agent Panel [English(en)]
      |----------------------------------------------------------------------------------------
      |
      | The following language lines are used in all Agent Panel related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */
    'agent_panel'       => 'Pannello Agente',
    'profile'           => 'Profilo',
    'change_password'   => 'Cambia Password',
    'sign_out'          => 'Esci',
    'Tickets'           => 'TICKETS',
    'inbox'             => 'Inbox',
    'my_tickets'        => 'Miei Tickets',
    'unassigned'        => 'Non Assegnati',
    'trash'             => 'Cestino',
    'Updates'           => 'AGGIORNAMENTI',
    'no_new_updates'    => 'Nessun nuovo aggiornamento',
    'check_for_updates' => 'Controlla aggiornamenti',
    'open'              => 'Apri',
    'inprogress'        => 'In elaborazione',
    'closed'            => 'chiuso',
    'Departments'       => 'DIPARTIMENTI',
    'tools'             => 'Strumenti',
    'canned'            => 'Canned',
    'knowledge_base'    => 'Knowledge Base',
    'loading'           => 'Caricando',
    'ratings'           => 'Ratings',
    'please_rate'       => 'Per favore rate:',
    'ticket_ratings'    => 'TICKET RATING',
    /*
      |-----------------------------------------------
      |  Profile
      |-----------------------------------------------
     */
    'user_information'    => 'informazioni utente',
    'time_zone'           => 'Time-zone',
    'phone_number'        => 'Numero di Telefono',
    'contact_information' => 'infomazioni Contatto',
    /*
      |-----------------------------------------------
      |  Dashboard
      |-----------------------------------------------
     */
    'dashboard'  => 'Cruscotto',
    'line_chart' => 'Tabella lineare',
    'statistics' => 'Statistiche',
    'opened'     => 'Aperto',
    'resolved'   => 'Risolto',
    'closed'     => 'Chiuso',
    'deleted'    => 'Cancellato',
    /*
      |------------------------------------------------
      |User Page
      |------------------------------------------------
     */
    'user_directory'  => 'User Directory',
    'ban'             => 'Banna',
    'user'            => 'Utente',
    'users'           => 'Utenti',
    'create_user'     => 'Crea Utente',
    'full_name'       => 'Nome Completo',
    'mobile'          => 'Mobile',
    'last_login'      => 'Ultimo Login',
    'user_profile'    => 'Profilo Utente',
    'assign'          => 'Assegna',
    'open_tickets'    => 'Tickets',
    'closed_tickets'  => 'Ticket Chiusi',
    'deleted_tickets' => 'Cancella Tickets',
    /*
      |------------------------------------------------
      |Organization Page
      |------------------------------------------------
     */
    'organizations'                 => 'Organizzazioni',
    'organization'                  => 'Organizzazione',
    'create_organization'           => 'Crea Organizzazione',
    'account_manager'               => 'Account Manager',
    'update'                        => 'Aggiorna',
    'please_select_an_organization' => 'Per favore seleziona una Organizzazione',
    'please_select_an_user'         => 'Per favore seleziona un utente',
    'organization_profile'          => 'Profilo Organizzazione',
    'organization-s_head'           => "Organization's Head",
    'select_department_manager'     => 'Seleziona Managere Dipartimento',
    'users_of'                      => 'Utenti di',
    /*
      |----------------------------------------------
      |  Ticket page
      |----------------------------------------------
     */
    'subject'                                         => 'Soggetto',
    'ticket_id'                                       => 'Ticket ID',
    'priority'                                        => 'Priorità',
    'from'                                            => 'Da',
    'last_replier'                                    => 'Ultimo a Rispondere',
    'assigned_to'                                     => 'Assegnato A',
    'last_activity'                                   => 'Ultima Attività',
    'answered'                                        => 'Risposto',
    'assigned'                                        => 'Assegnato',
    'create_ticket'                                   => 'Crea Ticket',
    'tickets'                                         => 'Tickets',
    'open'                                            => 'Apri',
    'Ticket_Information'                              => 'INFORMAZIONE TICKET',
    'Ticket_Id'                                       => 'ID TICKET',
    'User'                                            => 'UTENTE',
    'Unassigned'                                      => 'NON ASSEGNATO',
    'generate_pdf'                                    => 'Genera PDF',
    'change_status'                                   => 'Cambia Status',
    'more'                                            => 'Più',
    'delete_ticket'                                   => 'Cancella Ticket',
    'emergency'                                       => 'Emergenza',
    'high'                                            => 'Alta',
    'medium'                                          => 'Media',
    'low'                                             => 'Bassa',
    'sla_plan'                                        => 'SLA Plan',
    'created_date'                                    => 'Data Creata',
    'due_date'                                        => 'Data di Scadenza',
    'last_response'                                   => 'Ultima Risposta',
    'source'                                          => 'Sorgente',
    'last_message'                                    => 'Ultimo Messaggio',
    'reply'                                           => 'Risposta',
    'response'                                        => 'Resposta',
    'reply_content'                                   => 'Contenuto Riposta',
    'attachment'                                      => 'Allegato',
    'internal_note'                                   => 'Nota Interna',
    'this_ticket_is_under_banned_user'                => 'Questo ticket è di un utente bannato',
    'ticket_source'                                   => 'Sorgente Ticket',
    'are_you_sure_to_ban'                             => 'Sicuro di voler bannare',
    'whome_do_you_want_to_assign_ticket'              => 'A chi vuoi assegnare il ticket',
    'are_you_sure_you_want_to_surrender_this_ticket'  => 'Are you sure you want to surrender this Ticket',
    'add_collaborator'                                => 'Aggiungi Collaboratore',
    'search_existing_users'                           => 'Cerca utenti esistenti',
    'add_new_user'                                    => 'Aggiungi nuovo Utente',
    'search_existing_users_or_add_new_users'          => 'Cerca utenti esistenti o aggiungi nuovi utenti',
    'search_by_email'                                 => 'Cerca per Email',
    'list_of_collaborators_of_this_ticket'            => 'Lista dei Collaboratori di questo Ticket',
    'submit'                                          => 'Invia',
    'max'                                             => 'Max',
    'add_cc'                                          => 'Aggiungi CC',
    'recepients'                                      => 'Riceventi',
    'select_a_canned_response'                        => 'Seleziona una Canned Response',
    'assign_to'                                       => 'Assegna A',
    'detail'                                          => 'Dettaglio',
    'user_details'                                    => 'Dettagli Utente',
    'ticket_option'                                   => 'Opzioni Ticket',
    'ticket_detail'                                   => 'Dettagli Ticket',
    'Assigned_To'                                     => 'ASSEGNATO A',
    'locked-ticket'                                   => 'Allerta! Questo ticket è etato bloccato da un altro utente ed è al momento in risposta.',
    'access-ticket'                                   => 'Allerta! Questo ticket è etato bloccato da te per ',
    'minutes'                                         => ' minuti',
    'in_minutes'                                      => 'In minuti',
    'add_another_owner'                               => 'Aggiungi un altro possessore',
    'user-not-found'                                  => 'Utente non trovato.Prova ancora o aggiungi un nuovo utente.',
    'change-success'                                  => 'Successo! Il possessore di questo ticket è stato cambiato.',
    'user-exists'                                     => 'Utente già esistente. Prova a cercare questo stesso utente.',
    'valid-email'                                     => 'Inserisci un indirizzo email valido.',
    'search_user'                                     => 'Cerca utente',
     'merge-ticket'                                   => 'Unisci ticket',
    'title'                                           => 'Titolo',
    'merge'                                           => 'Unisci',
    'select_tickets'                                  => 'Seleziona ticket da unire',
    'select-pparent-ticket'                           => 'Seleziona un ticket padre',
    'merge-reason'                                    => 'Motivazione unione',
    'get_merge_message'                               => 'Questo ticket è stato unito con il ticket',
    'ticket_merged'                                   => ' è stato unito con il ticket.',
    'no-tickets-to-merge'                             => 'Non ci sono altri ticket di prorietà del possessore di questo ticket.',
    'merge-error'                                     => 'Richiesta non processabile riprova in seguito.',
    'merge-success'                                   => 'Tickets uniti con successo.',
    'merge-error2'                                    => 'Per favore selzeziona un ticket da unire.',
    'select-tickets-to merge'                         => 'seleziona due o più ticket da unire',
    'different-users'                                 => 'Tickte da utenti diversi',

    /*
      |------------------------------------------------
      |Tools Page
      |------------------------------------------------
     */
    'canned_response'        => 'Canned Response',
    'create_canned_response' => 'Create Canned Response',
    'surrender'              => 'Surrender',
    'view'                   => 'Vista',
    /*
      |-----------------------------------------------
      | Main text
      |-----------------------------------------------
     */
    'copyright'           => 'Copyright',
    'all_rights_reserved' => 'Tutti i diritti riservati',
    'powered_by'          => 'Sviluppato da',
    /*
      |------------------------------------------------
      |Guest-User Page
      |------------------------------------------------
     */
    'issue_summary'        => 'Sommario Problema',
    'issue_details'        => 'Dettagli Problema',
    'contact_informations' => 'Informazioni contatto',
    'contact_details'      => 'Dettagli Contatto',
    'role'                 => 'Ruolo',
    'ext'                  => 'EXT',
    'profile_pic'          => 'Foto Profilo',
    'agent_sign'           => 'Firma Agente',
    'inactive'             => 'Inattivo',
    'male'                 => 'Uomo',
    'female'               => 'Donna',
    'old_password'         => 'Vecchia Password',
    'new_password'         => 'Nuova Password',
    'confirm_password'     => 'Conferma Password',
    'gender'               => 'Genere',
    'ticket_number'        => 'Numero di Ticket',
    'content'              => 'Contenuto',
    /*
      |------------------------------------------------
      |   Error Pages
      |------------------------------------------------
     */
    'not_found'                                       => 'Non trovato',
    'oops_page_not_found'                             => 'Oops! Pagina non trovata',
    'we_could_not_find_the_page_you_were_looking_for' => 'Impossibile trovare la pagina che stavi cercando',
    'internal_server_error'                           => 'Errore server interno',
    'be_right_back'                                   => 'Torna indietro',
    'sorry'                                           => 'Spiacente',
    'we_are_working_on_it'                            => 'Ci stiamo lavorando',
    'category'                                        => 'Categoria',
    'addcategory'                                     => 'Aggiungi Categoria',
    'allcategory'                                     => 'Tutte le Categorie',
    'article'                                         => 'Articolo',
    'articles'                                        => 'Articoli',
    'addarticle'                                      => 'Aggiungi Articolo',
    'allarticle'                                      => 'Tutti gli Articoli',
    'pages'                                           => 'Pagine',
    'addpages'                                        => 'Aggiungi Pagine',
    'allpages'                                        => 'Tutte le pagine',
    'widgets'                                         => 'Widgets',
    'footer1'                                         => 'Footer 1',
    'footer2'                                         => 'Footer 2',
    'footer3'                                         => 'Footer 3',
    'footer4'                                         => 'Footer 4',
    'sidewidget1'                                     => 'Side Widget 1',
    'sidewidget2'                                     => 'Side Widget 2',
    'comments'                                        => 'Commenti',
    'settings'                                        => 'Settaggi',
    'parent'                                          => 'Padre',
    'description'                                     => 'Descrizione',
    'enter_the_description'                           => 'Inserisci la Descrizione',
    'publish'                                         => 'Pubblica',
    'published'                                       => 'Pubblicato',
    'draft'                                           => 'Bozza',
    'create_a_category'                               => 'Crea una Categoria',
    'add'                                             => 'Aggiungi',
    'social'                                          => 'Social',
    'comment'                                         => 'Commento',
    'not_published'                                   => 'Non Pubblicato',
    'numberofelementstodisplay'                       => 'numero elementi da visualizzare',
    //======================================
    'language'                                                                 => 'Lingua',
    'save'                                                                     => 'Salva',
    'create'                                                                   => 'Crea',
    'dateformat'                                                               => 'Formato Data',
    'slug'                                                                     => 'Slug',
    'read_more'                                                                => 'leggi di più',
    'view_all'                                                                 => 'Vedi tutto',
    'categories'                                                               => 'Categorie',
    'need_more_support'                                                        => 'Necessita più supporto',
    'if_you_did_not_find_an_answer_please_raise_a_ticket_describing_the_issue' => 'Se non hai trovato una risposta, per favore apri un ticket con al descrizione del problema',
    'have_a_question?_type_your_search_term_here'                              => 'Hai una domanda? Scrivi una parola da cercare qui...',
    'search'                                                                   => 'Cerca',
    'search_results'                                                           => 'Risultati Ricerca',
    'frequently_asked_questions'                                               => 'Domande Frequenti',
    'leave_a_reply'                                                            => 'Lascia una Risposta',
    'post_message'                                                             => 'Post Message',
    /*
      |--------------------------------------------------------------------------------------
      |  Client Panel [English(en)]
      |--------------------------------------------------------------------------------------
      | The following language lines are used in all Agent Panel related issues to translate
      | some words in view to English. You are free to change them to anything you want to
      | customize your views to better match your application.
      |
     */
    'home'                => 'Home',
    'submit_a_ticket'     => 'Invia un Ticket',
    'my_profile'          => 'Mio Profilo',
    'log_out'             => 'Logout',
    'forgot_password'     => 'Password Dimenticata',
    'create_account'      => 'Crea un Account',
    'you_are_here'        => 'Sei qui',
    'have_a_ticket'       => 'Have a Ticket',
    'check_ticket_status' => 'Controlla Status Ticket',
    'choose_a_help_topic' => 'Choose a Help Topic',
    'ticket_status'       => 'Status Ticket',
    'post_comment'        => 'Posta Commento',
    'plugin'              => 'Plugin',
];
