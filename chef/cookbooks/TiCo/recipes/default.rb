#
# Cookbook Name:: TiCo
# Recipe:: default
#
# Copyright 2016, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

#
# Create application config
#
template "#{node['TiCo']['rootFolder']}/.env" do
	source ".env.erb"
	mode "0644"
	owner "root"
	group "root"
end