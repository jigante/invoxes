set :application, "Fatture Facili"
# set :domain,      "#{application}.com"
set :domain,      "fatturefacili.it"
# set :deploy_to,   "/var/www/#{domain}"
set :deploy_to,   "/var/www/fatturefacili.it/application"
set :app_path,    "app"
# set :web_path, "web"

# SCM info
# set :repository,  "#{domain}:/var/repos/#{application}.git"
set :repository,  "git@github.com:jigante/fatture-online.git"
set :scm,         :git
set :deploy_via, :remote_cache

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# General config stuff
set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true

# User details for the production server
set :user, "fatturefacili"
set :use_sudo, false
ssh_options[:port] = 7822

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL