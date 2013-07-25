set :application, "Invoxes - Dev"
# set :domain,      "#{application}.com"
set :domain,      "dev.invoxes.com"
# set :deploy_to,   "/var/www/#{domain}"
set :deploy_to,   "/var/www/dev.invoxes.com/application"
set :app_path,    "app"
set :web_path,    "web"

# SCM info
# set :repository,  "#{domain}:/var/repos/#{application}.git"
set :repository,  "git@github.com:jigante/invoxes.git"
set :scm,         :git
set :deploy_via, :remote_cache

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3

# General config stuff
set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", web_path + "/stats", web_path + "/error", "vendor"]
set :use_composer, true

# User details for the production server
set :user, "dev_invoxes"
set :use_sudo, false
ssh_options[:port] = 7822

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL