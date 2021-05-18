SET TRANSACTION ISOLATION LEVEL SERIALIZABLE

create table accounts(
    username varchar(30) primary key,
    passwordU varchar(60) not null,
    email varchar(60) not null unique,
    vkey varchar(60) not null unique,
    verified bit default 0,
    creationdate timestamp default CURRENT_TIMESTAMP
)DEFAULT CHARSET=utf8;

create table software(
    name varchar(60) primary key,
    description text not null,
    price float default 0,
    available int default 0,
    link text
)DEFAULT CHARSET=utf8;

create table orders(
    order_id varchar(50) primary key,
    account varchar(30),
    software_name varchar(60),
    data timestamp default CURRENT_TIMESTAMP,
    product_key varchar(30) not null unique,
    foreign key (account) references accounts(username) on update cascade,
    foreign key (software_name) references software(name) on update cascade
)DEFAULT CHARSET=utf8;

INSERT INTO `my_pertile4465`.`software` (`name`, `description`, `price`, `available`, `link`) 
VALUES ('Adobe After Effects', '<h1>Non c''è nulla che non puoi creare con After Effects.</h1>Crea titoli, introduzioni e transizioni di livello cinematografico per i tuoi filmati; rimuovi un oggetto da una clip; accendi un fuoco o scatena un temporale; anima un logo o un personaggio. Puoi anche navigare e progettare in uno spazio 3D. Con After Effects, il software per eccellenza nel settore dell''animazione e degli effetti speciali, puoi trasformare qualsiasi idea in un progetto animato.<br><br><h3>Ringraziamenti scorrevoli. Parole che ruotano. Titoli in un vortice.</h3>Anima titoli, ringraziamenti e sottopancia. Puoi partire da zero o con i predefiniti disponibili direttamente nell''app. Dalla rotazione agli effetti di scorrimento e scivolamento, il tuo testo è sempre in movimento.<br><br><h3>Scatenati con le animazioni.</h3>Usa i fotogrammi chiave o le espressioni per animare qualsiasi cosa oppure usa i predefiniti per avviare subito i tuoi progetti e ottenere risultati originali.', '439.99', '1000', 'https://www.adobe.com/it/products/aftereffects.html'),
('Avast Premium', '<h1>Protezione dalle più pericolose minacce online</h1>Avast Premium Security assicura protezione da tutte le minacce online, inclusi siti Web contraffatti e ransomware.<br><br><h3>Ora puoi usare l''home banking e fare shopping online in tutta sicurezza</h3>I siti Web contraffatti (falsi) sono uno dei più vecchi trucchi utilizzati dagli hacker. Avast Premium Security esegue la scansione dei siti Web per rilevare eventuali rischi per computer e telefoni cellulari, consentendo di effettuare acquisti e operazioni bancarie in tutta sicurezza da qualsiasi dispositivo.<br><br><h3>Blocca gli hacker che tentano di assumere il controllo del tuo PC</h3>Gli attacchi con accesso remoto sono sempre più numerosi. Non c''è niente di peggio di un hacker che assume in remoto il controllo del tuo PC per infettarlo con il malware o bloccare i file con il ransomware. Avast Premium Security adesso protegge il PC da questo tipo di attacchi.', '49.99', '20000', 'https://www.avast.com/it-it/premium-security#pc');

INSERT INTO `my_pertile4465`.`software` (`name`, `description`, `price`, `available`, `link`) 
VALUES ('CorelDRAW Graphic Suite 2021', '<h1>Dal modello iniziale al wow finale</h1>Inizia il tuo viaggio di progettazione con il piede giusto con CorelDRAW® Graphics Suite 2021: una suite completa di applicazioni di progettazione professionale per l’illustrazione vettoriale, il layout, il fotoritocco e altro ancora, appositamente progettata per la tua piattaforma preferita.<br><br><h3>Tutti gli strumenti che ti occorrono per affrontare qualsiasi progetto</h3>Crea qualsiasi progetto con questa potente applicazione di progettazione grafica completa di tutte le funzionalità per l’illustrazione vettoriale, l’impaginazione e altro ancora.<br><br><h3>Il cielo è l’unico limite!</h3>Dalla produzione e l’ingegneria, alla produzione di insegne, al marketing e altro ancora, CorelDRAW Graphics Suite è usato da diversi grafici, settori e aziende in tutto il mondo.', '719.00', '50', 'https://www.coreldraw.com/it/product/coreldraw/'),
('McAfee Total Protection Antivirus 2021', '<h1>È più di un semplice antivirus - È massima tranquillità</h1>Tra le nostre soluzioni di sicurezza, McAfee Total Protection si distingue per la sua combinazione di strumenti e funzionalità per la difesa dai virus, la tutela della privacy e la protezione dell’identità. Difenditi dagli attacchi di virus, malware, ransomware e spyware più recenti e tutela la tua identità e la tua privacy.<br>
Adesso che ti sei iscritto al rinnovo automatico potrai accedere alla nostra VPN sicura, che fornisce crittografia di livello bancario per proteggere i tuoi dati personali e le tue attività online.<br><br><h3>Protezione per più dispositivi per la famiglia connessa di oggi</h3>Con tutti i PC Windows, i Mac, i tablet e gli smartphone utilizzati dalla tua famiglia giorno per giorno è abbastanza difficile tenerne traccia, e ancora di più proteggerli. Con un unico abbonamento a McAfee Total Protection puoi proteggere cinque o dieci dispositivi di tutta la famiglia senza interruzioni e rallentamenti', '44,95', '10000', 'https://www.mcafee.com/it-it/antivirus/mcafee-total-protection.html');

INSERT INTO `my_pertile4465`.`software` (`name`, `description`, `price`, `available`, `link`) 
VALUES ('Microsoft Project 2019 Professional', '<h1>Migliora la selezione e la consegna dei progetti
</h1>Project  Professional nella versione 2019 è uno strumento che si fa carico di tutti gli aspetti del Project Management: con questo software i Project Manager possono gestire risorse quali collaboratori, tempi e budget e mantenere la visione d''insieme anche nel caso in cui più progetti siano portati avanti contemporaneamente. Inoltre, i progetti possono avere dimensioni quasi illimitate, dalle attività più piccole fino a quelle che si articolano su più anni e che quindi rivestono una particolare importanza. La collaborazione ai progetti di questo tipo è possibile sia in locale utilizzando una rete aziendale oppure tramite il cloud. In questo modo, sia le piccole aziende sia le imprese più grandi hanno la possibilità di aggiornare costantemente gli specifici progetti risparmiando tempo e denaro.<br><br><h3>Facilità d''uso</h3>Gli utenti che non hanno ancora provato Microsoft Project Professional acquisiranno rapidamente dimestichezza con le ampie funzioni del programma grazie ai modelli, che sono forniti con il software e che consentono di creare persino progetti complessi nel giro di pochi minuti. Questi modelli possono essere modificati ed archiviati per essere utilizzati in altri progetti: anche per la redazione del rapporto di gestione per gli anni futuri, ad esempio, non sarà necessario ripartire da zero, bensì sarà sufficiente apportare i cambiamenti necessari. La maggior parte delle funzioni della versione precedente e i più conosciuti tool sono riproposti in Microsoft Project Professional 2019, fatto che faciliterà il passaggio alla nuova edizione anche agli utenti più esperti.', '67.09', '300', 'https://www.microsoft.com/it-it/microsoft-365/p/project-professional-2019/cfq7ttc0k7cj?activetab=pivot%3aoverviewtab'),
('Norton 360 Deluxe', '<h1>Potente protezione per i tuoi dispositivi e la privacy online dell''intera famiglia, tutto in un’unica soluzione</h1>Norton 360 Deluxe offre una protezione anti-malware completa per 5 PC, Mac, dispositivi Android o iOS, oltre che la protezione minori‡ per proteggere i bambini online, Password Manager per archiviare e gestire password e backup del PC nel cloud4.<br>
Norton 360 Deluxe include anche una VPN per 5 dispositivi e SafeCam per PC. Secure VPN ti consente di navigare sul Web in modo più sicuro e anonimo, anche su Wi-Fi pubblici, e SafeCam5 ti segnala e ti aiuta a bloccare gli accessi non autorizzati alla webcam del tuo PC.', '34.99', '800', 'https://it.norton.com/products/norton-360-deluxe');

INSERT INTO `my_pertile4465`.`software` (`name`, `description`, `price`, `available`, `link`)
VALUES ('Vegas Pro ', '<h1>PRODUZIONE VIDEO STRAORDINARIAMENTE VELOCE & EFFICIENTE</h1>VEGAS Pro sfrutta tutta la potenza dell''Intelligenza artificiale per portare la produzione video due passi avanti. Il programma offre un''interfaccia estremamente flessibile, la gestione completa dei media, un editing audio avanzato e funzioni di mastering. SOUND FORGE Pro incluso oltre all''accelerazione hardware leader del settore. È ora di caricare al massimo la tua creatività!<br><br><h3>Accelerazione hardware GPU leader di mercato</h3>Sfrutta la potenza dell''accelerazione via GPU e goditi la massima stabilità, il rendering veloce e la riproduzione fluida. VEGAS Pro 18 configura automaticamente le impostazioni ottimali per ottenere il massimo dalla GPU.<br><br><h3>EDITING AUDIO DI MASSIMA PRECISIONE</h3>Quando si tratta di editing audio, niente batte SOUND FORGE Pro 14 con il suo flusso di lavoro affidabile, innovativo e dinamico. Ora, come parte essenziale del VEGAS Pro, SOUND FORGE Pro migliorerà il tuo flusso di lavoro audio. Modifica, ripara e masterizza il contenuto audio del tuo progetto video al massimo livello. Riduci la distorsione o rimuovi il rumore di fondo con una unica sessione di editing direttamente da un evento nella Timeline di VEGAS Pro.', '399.99', '950', 'https://www.vegascreativesoftware.com/it/vegas-pro/');