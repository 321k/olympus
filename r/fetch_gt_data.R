library(RCurl)
library(RMySQL)


setwd('/var/www/html/olympus/r')
source("gt_scripts.R")
con = dbConnect(MySQL(), user = 'erik', password = 'johansson', dbname='apollo')

request <- dbGetQuery(con,"select * from gt_urls;")

for(i in 1:nrow(request)){
  lynx_commands = lynx_script(request$url[i], 'anton.mainhof@gmail.com', 'oodixach', '')
  write.table(lynx_commands, 'lynx_commands.txt', row.names=F, col.names=F, quote=F)
  system("lynx -cmd_script=/var/www/html/olympus/r/lynx_commands.txt www.google.com")
  files = list.files()
  files = files[which(grepl("gt_download", files))]
  if(length(files>1)) files = files[length(files)]
  files = readGT(files)
  if(nrow(files)==0) next()
  files$gt_urls_id = request$id[i]
  dbWriteTable(con, 'search_volume', files, append=T)
}