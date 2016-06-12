

library(RCurl)
library(RMySQL)

source("gt_scripts.R")

con = dbConnect(MySQL(), user = 'erik', password = 'johansson', dbname='apollo')

request <- dbGetQuery(con,"select min(id) as id from requests where status is null;")

update_query <- paste("update requests set status = 'processing' where id=", request$id ,";", sep='')
dbSendQuery(con, update_query)

request_content_query <- paste("select * from request_contents where request_id = ", request$id, ";", sep='')
request_content <- dbGetQuery(con,request_content_query)

request_content$year[which(request_content$year==0)] <- NA
request_content$month[which(request_content$month==0)] <- NA
request_content$length[which(request_content$length==0)] <- NA

url_list <- list()
counter <- 1
for(i in 1:nrow(request_content)){
	keywords <- c(request_content$keyword_1[i], request_content$keyword_1[i], request_content$keyword_2[i], request_content$keyword_3[i], request_content$keyword_4[i], request_content$keyword_5[i])
	url_list[[counter]] <- URL_GT(keywords, request_content$country[i], request_content$region[i], request_content$year[i], request_content$month[i], request_content$length[i])
	add_url_to_db_query <- paste("insert into gt_results (request_content_id, url) values (", request_content$id[i], ", '", url_list[[counter]] , "');", sep='')
	dbSendQuery(con, add_url_to_db_query)
	counter <- counter + 1
}



