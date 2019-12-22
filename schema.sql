CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;
USE taskforce;
CREATE TABLE categories (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title           VARCHAR(64) NOT NULL,
    icon            VARCHAR(64) NOT NULL,
    PRIMARY KEY (id)
);
CREATE TABLE cities (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title           VARCHAR(64) NOT NULL,
    lat             DECIMAL(10,7),
    lng            DECIMAL(10,7),
    PRIMARY KEY (id)
);
CREATE TABLE users (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    cities_id       INT UNSIGNED NOT NULL,
    role            ENUM('client', 'executive') NOT NULL,
    message_alert   TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
    action_alert    TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
    review_alert    TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
    show_contacts   TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
    show_profile    TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
    name            VARCHAR(50) NOT NULL,
    avatar_path     VARCHAR(128),
    dt_reg          TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    dt_birth        DATE,
    dt_last_visit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    email           VARCHAR(64) UNIQUE NOT NULL,
    phone           VARCHAR(32),
    skype           VARCHAR(64),
    oth_contact     VARCHAR(64),
    password        CHAR(128) NOT NULL,
    longitude       DECIMAL(10,7),
    latitude        DECIMAL(10,7),
    bio             VARCHAR(16383),
    PRIMARY KEY (id),
    FOREIGN KEY (cities_id) REFERENCES cities(id)
);
CREATE TABLE tasks (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_client_id     INT UNSIGNED NOT NULL,
    users_executive_id  INT UNSIGNED NOT NULL,
    categories_id       INT UNSIGNED NOT NULL,
    cities_id           INT UNSIGNED NOT NULL,
    status              ENUM('new', 'completed', 'cancelled', 'failed', 'in progress') NOT NULL,
    title               VARCHAR(128) NOT NULL,
    description         VARCHAR(255) NOT NULL,
    budget              INT UNSIGNED DEFAULT NULL,
    dt_create           TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    dt_end              TIMESTAMP,
    longitude           DECIMAL(10,7),
    latitude            DECIMAL(10,7),
    view_count          INT,
    PRIMARY KEY (id),
    FOREIGN KEY (users_client_id) REFERENCES users(id),
    FOREIGN KEY (users_executive_id) REFERENCES users(id),
    FOREIGN KEY (categories_id) REFERENCES categories(id),
    FOREIGN KEY (cities_id) REFERENCES cities(id)
);
CREATE TABLE reviews (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_client_id     INT UNSIGNED NOT NULL,
    users_executive_id  INT UNSIGNED NOT NULL,
    tasks_id            INT UNSIGNED NOT NULL,
    comment             VARCHAR(16383),
    rate                ENUM('1', '2', '3', '4', '5') NOT NULL,
    dt_create           TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (users_client_id) REFERENCES users(id),
    FOREIGN KEY (users_executive_id) REFERENCES users(id),
    FOREIGN KEY (tasks_id) REFERENCES tasks(id)
);
CREATE TABLE users_specialisations (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_id            INT UNSIGNED NOT NULL,
    categories_id       INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users(id),
    FOREIGN KEY (categories_id) REFERENCES categories(id)
);
CREATE TABLE task_replies (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_executive_id  INT UNSIGNED NOT NULL,
    tasks_id            INT UNSIGNED NOT NULL,
    comment             VARCHAR(16383),
    price               INT UNSIGNED NOT NULL,
    dt_create           TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (users_executive_id) REFERENCES users(id),
    FOREIGN KEY (tasks_id) REFERENCES tasks(id)
);
CREATE TABLE messages (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_author_id     INT UNSIGNED NOT NULL,
    users_addressee_id  INT UNSIGNED NOT NULL,
    tasks_id            INT UNSIGNED NOT NULL,
    dt_create           TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    text                VARCHAR(16383) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (users_author_id) REFERENCES users(id),
    FOREIGN KEY (users_addressee_id) REFERENCES users(id),
    FOREIGN KEY (tasks_id) REFERENCES tasks(id)
);
CREATE TABLE alerts (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_id            INT UNSIGNED NOT NULL,
    task_replies_id     INT UNSIGNED,
    tasks_id            INT UNSIGNED NOT NULL,
    messages_id         INT UNSIGNED,
    note_type           ENUM('answer', 'message', 'refuse', 'start', 'finish') NOT NULL,
    is_new              TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
    dt_create           TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (task_replies_id) REFERENCES task_replies(id),
    FOREIGN KEY (tasks_id) REFERENCES tasks(id),
    FOREIGN KEY (messages_id) REFERENCES messages(id),
    FOREIGN KEY (users_id) REFERENCES users(id)
);
CREATE TABLE attachments (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_id        INT UNSIGNED NOT NULL,
    tasks_id        INT UNSIGNED NOT NULL,
    attach_type     ENUM('task', 'user') NOT NULL,
    image_path      VARCHAR(128) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (users_id) REFERENCES users(id),
    FOREIGN KEY (tasks_id) REFERENCES tasks(id)
);
CREATE TABLE clients_favorites_executors (
    id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    users_client_id     INT UNSIGNED NOT NULL,
    users_executive_id  INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (users_client_id) REFERENCES users(id),
    FOREIGN KEY (users_executive_id) REFERENCES users(id)
);
CREATE TABLE stop_words (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    value      VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE FULLTEXT INDEX person ON users(name);
CREATE FULLTEXT INDEX task_search ON tasks(title);
