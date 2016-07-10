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
  script[[5]] <- c(
  '<tab>',
  '^J',
  '<tab>',
  '<tab>')
  script[[6]] <- substring(password, 1:nchar(password), 1:nchar(password))
  script[[7]] <- c(
  '^J'
  ,'^J'
  ,'A'
  ,'A'
  ,'A'
  ,'A'
  ,'g')
  script[[8]] <- substring(url, 1:nchar(url), 1:nchar(url))
  script[[9]] <- c(
  '^J',
  'A',
  '<tab>',
  '<tab>')
  script[[10]]  <- c(
  'D',
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
  
  script[[11]] <- substring(path, 1:nchar(path), 1:nchar(path))
  script[[12]] <- c(
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