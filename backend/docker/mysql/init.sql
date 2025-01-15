-- Main application database
CREATE DATABASE IF NOT EXISTS pagecraft;
CREATE USER 'pagecraft_user'@'%' IDENTIFIED BY 'pagecraft';
GRANT ALL PRIVILEGES ON pagecraft.* TO 'pagecraft_user'@'%';

-- Matomo analytics database
CREATE DATABASE IF NOT EXISTS matomo;
CREATE USER 'matomo_user'@'%' IDENTIFIED BY 'matomo';
GRANT ALL PRIVILEGES ON matomo.* TO 'matomo_user'@'%';

FLUSH PRIVILEGES;
