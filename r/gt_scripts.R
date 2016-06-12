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


# Function that creates the instructions for lynx to fetch data
lynx_script <- function(url, username, password, directory){
  file_name <- paste('google_trends_download ', Sys.time(), '.csv.gz', sep='')
  path <- paste(directory, file_name, sep='')
  script <- list()

  script[[1]] <- c('A'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'Down Arrow'
  ,'^J'
  ,'A')
  script[[2]] <- substring(username, 1:nchar(username), 1:nchar(username))
  script[[3]] <- '<tab>'
  script[[4]] <- substring(password, 1:nchar(password), 1:nchar(password))
  script[[5]] <- c('^J'
  ,'^J'
  ,'A'
  ,'A'
  ,'A'
  ,'A'
  ,'A'
  ,'g')
  
  script[[6]] <- substring(url, 1:nchar(url), 1:nchar(url))
  script[[7]] <- c(
  '^J',
  'A',
  'D',
  'Down Arrow',
  'Down Arrow',
  'Down Arrow',
  '^J',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>',
  '<delete>'
  )
  
  script[[8]] <- substring(path, 1:nchar(path), 1:nchar(path))
  script[[9]] <- c(
  '^J',
  'q',
  'y'
  )
  
  res <- vector()
  for(i in 1:length(script)){
    res <- c(res, script[[i]])
  }
  for(i in 1:length(res)){
    res[i] <- paste('key', res[i])
  }
  res <- paste(res,collapse="\n")
  return(res)
}