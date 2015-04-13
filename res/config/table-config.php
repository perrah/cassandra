<?php
return array (
        "users" => 
            "CREATE TABLE users (
            user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(30) NOT NULL,
            password VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            reg_date DATETIME,
            api_key VARCHAR(50),
            permissions VARCHAR (30) NOT NULL,
            UNIQUE (user_id)
            )",
        "resources" =>
            "CREATE TABLE resources (
            resource_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
			parent_id VARCHAR(30) NOT NULL,
            resource_name VARCHAR(30) NOT NULL,
            resource_type VARCHAR(30) NOT NULL,
            source_type VARCHAR(30),
            created_on TIMESTAMP,
            size INT,
			location VARCHAR(30),
            UNIQUE (resource_id)
            )",
        "user_resources" =>
            "CREATE TABLE user_resources (
            user_resource_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            user_id INT UNSIGNED NOT NULL,
            resource_id INT UNSIGNED NOT NULL,
            permissions INT,
            FOREIGN KEY (user_id) REFERENCES users(user_id),
            FOREIGN KEY (resource_id) REFERENCES resources(resource_id),
            UNIQUE (user_resource_id)
            )",
        "remote_sources" =>
            "CREATE TABLE remote_sources (
            source_id INT UNSIGNED NOT NULL PRIMARY KEY,
            resource_id INT UNSIGNED NOT NULL,
            host VARCHAR(30) NOT NULL,
            database_name VARCHAR(30) NOT NULL,
            table_name VARCHAR(30) NOT NULL,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(30) NOT NULL,
            FOREIGN KEY (resource_id) REFERENCES resources(resource_id),
            UNIQUE (source_id)
            )",
        "task_log" =>
            "CREATE TABLE task_log (
            log_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            user_id INT UNSIGNED NOT NULL,
            resource_type VARCHAR(30) NOT NULL,
            date DATETIME NOT NULL,
            duration FLOAT NOT NULL,
            status INT NOT NULL,
            description VARCHAR(30) NOT NULL,
            size INT NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(user_id),
            UNIQUE (log_id)
            )"
        )

?>
