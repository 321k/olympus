library(RCurl)
library(RMySQL)

source("gt_scripts.R")
setwd('/var/www/html/olympus/R')
con = dbConnect(MySQL(), user = 'erik', password = 'johansson', dbname='apollo')

request <- dbGetQuery(con,"select * from gt_urls;")

for(i in 1:nrow(request)){
  lynx_commands = lynx_script(request$url[i], 'anton.mainhof@gmail.com', 'oodixach', '')
  write.table(lynx_commands, '/var/www/html/olympus/r/lynx_commands.txt', row.names=F, col.names=F, quote=F)
  system("lynx -cmd_script=/var/www/html/olympus/r/lynx_commands.txt www.google.com")
}