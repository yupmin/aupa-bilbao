############################################
# Setup project
############################################

set :application, "aupa-bilbao"
set :repo_url, "https://github.com/yupmin/aupa-bilbao.git"
set :scm, :git

############################################
# Setup Capistrano
############################################

set :log_level, :info
set :use_sudo, false

set :ssh_options, {
  forward_agent: true
}

set :keep_releases, 3

############################################
# Linked files and directories (symlinks)
############################################

set :linked_files, [ "app/config/parameters.yml" ]
set :linked_dirs, [f etch(:log_path), fetch(:web_path) + "/uploads" ]
set :file_permissions_paths, [ fetch(:log_path), fetch(:cache_path) ]

set :composer_install_flags, '--no-interaction --optimize-autoloader'

namespace :compile_and_upload do

  desc 'Compile and upload'
  task :gulp do
    if fetch(:env) == "prod"
      run_locally do
        execute "gulp prod"
      end
    else
      on roles(:all) do |host|
        execute "cd #{release_path}; npm install && gulp prod"
      end
    end
  end

  task :upload do
    if fetch(:env) == "prod"
      on roles(:all) do |host|
        upload! "#{fetch(:web_path)}/css", "#{release_path}/#{fetch(:web_name)}/css", recursive: true
        upload! "#{fetch(:web_path)}/js", "#{release_path}/#{fetch(:web_name)}/js", recursive: true
      end
    end
  end
end

namespace :deploy do
  after :updated, 'composer:install_executable'
  after :updated, 'compile_and_upload:gulp'
  after :updated, 'compile_and_upload:upload'
end
