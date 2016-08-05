######################################################################
# Setup Server
######################################################################
server "dev.company.com", user: "sshuser", roles: %w{web}
set :deploy_to, "/path/to/your/deployment/directory"
et :env, "dev"

######################################################################
# Capistrano Symfony - https://github.com/capistrano/symfony/#settings
######################################################################
set :file_permissions_users, ['www-data']
set :webserver_user, "www-data"

######################################################################
# Setup Git
######################################################################
set :branch, "master"
