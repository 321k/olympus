library(RMySQL)
require(lubridate)

setwd('/users/erik.johansson/olympus/')
source("r/gt_scripts.R")

# Sign in
user_id = 1
con = dbConnect(MySQL(),host = 'localhost', user = 'erik', password = 'johansson', dbname = 'apollo')

# Get order data
order = read.csv('csv/order_test.csv')
order$user_id = user_id

# Get keywords data
keywords = read.csv('csv/keywords_test.csv')

# Create order
dbWriteTable(con, 'orders', order, append=T, row.names=F)
order_id = dbGetQuery(con, paste('select max(id) from orders where user_id = ', user_id, sep=''))[,1]

# Add keywords to order
keywords$order_id = order_id
dbWriteTable(con, 'keywords', keywords, append = T, row.names=F)

# Determine what type of order it is
order_cost = 0
nrow(keywords)
order$data_frequency = 'daily'
order$year
order$month
order$length
order$comparable_keywords



URL_GT=function(keyword="", country=NA, region=NA, year=NA, month=1, length=3){
  
  start="http://www.google.com/trends/trendsReport?hl=en-US&q="
  end="&cmpt=q&content=1&export=1"
  geo=""
  date=""
  
  #Geographic restrictions
  if(!is.na(country)) {
    geo="&geo="
    geo=paste(geo, country, sep="")
    if(!is.na(region)) geo=paste(geo, "-", region, sep="")
  }
  
  queries=keyword[1]
  if(length(keyword)>1) {
    for(i in 2:length(keyword)){
      queries=paste(queries, "%2C ", keyword[i], sep="")
    }
  }
  
  #Dates
  if(!is.na(year)){
    date="&date="
    date=paste(date, month, "%2F", year, "%20", length, "m", sep="")
  }
  
  URL=paste(start, queries, geo, date, end, sep="")
  URL <- gsub(" ", "%20", URL)
  return(URL)
}



create_gt_links = function(order, keywords){
  
  # Determine the start date
  if(is.na(order$year)){
    start_date = as.Date('2004-01-01')
  } else {
    start_date = as.Date(paste(order$year, order$month, '01', sep='-'))
  }
  
  # Create a list of the start dates to go through
  quarters = ceiling(as.numeric(as.Date(Sys.time(), '%Y-%m-%d', tz='UTC') - start_date)/(30.5*3))
  yearmon = start_date
  for(i in 2:quarters){
    yearmon[i] = yearmon[i-1]
    month(yearmon[i]) = month(yearmon[i]) + 3
  }
  
  # If the keywords are to be comparable, do this
  if(order$comparable_keywords == 1){
    if(order$data_frequency == 'daily'){
      ceiling(nrow(keywords)/4) * ceiling(order$length/3) + ceiling(nrow(keywords)/5)
      
      comparison_keyword = as.character(keywords[1,1])
      remaining_keywords = as.character(keywords[-1,1])
      s = seq(1,length(remaining_keywords),4)
      sets = list()
      urls = vector()
      counter = 1
      
      for(i in 1:length(s)){
        sets[[i]] = c(comparison_keyword, remaining_keywords[i:(i+3)])
        
        for(j in 1:length(yearmon)){
          urls[counter] = URL_GT(sets[[i]], country = order$country, region = order$region, year = year(yearmon[j]), month = month(yearmon[j]), length=3)  
          counter = counter + 1
        }
      }
      
      s = seq(1,nrow(keywords),5)
      sets = list()
      for(i in 1:length(s)){
        sets[[i]] = keywords[i:(i+4),1]
        urls[counter] = URL_GT(sets[[i]], country = order$country, region = order$region)
        counter = counter + 1
      }
    }
    # If they don't have to be comparable, do this
    else if(order$data_frequency == 'weekly'){
      ceiling(nrow(keywords)/4)
      
      comparison_keyword = as.character(keywords[1,1])
      remaining_keywords = as.character(keywords[-1,1])
      s = seq(1,length(remaining_keywords),4)
      sets = list()
      urls = vector()
      for(i in 1:length(s)){
        sets[[i]] = c(comparison_keyword, remaining_keywords[i:(i+3)])
        urls[i] = URL_GT(sets[[i]], country = order$country, region = order$region, year = order$year, month = order$month, length=order$length)
      }
    }
  } 
  # If they don't have to be comparable, do this
  else if (order$comparable_keywords == 0) {
    ceiling(nrow(keywords)/5)
  }  
}
