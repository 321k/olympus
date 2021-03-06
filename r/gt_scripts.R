# Function that creates the instructions for lynx to fetch data
lynx_script <- function(url, username, password, directory){
  file_name <- paste('gt_download ', Sys.time(), '.csv', sep='')
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



readGT=function(filePath){
  rawFiles=list()
  
  for(i in 1:length(filePath)){
    if(length(filePath)==1) rawFiles[[1]]=read.csv(filePath, header=F, blank.lines.skip=F)
    if(length(filePath)>1) rawFiles[[i]]=read.csv(filePath[i], header=F, blank.lines.skip=F)
  }
  
  output=data.frame()
  name=vector()
  
  for(i in 1:length(rawFiles)){
    data=rawFiles[[i]]
    name=as.character(t(data[5,-1]))
    
    #Select the time series
    start=which(data[,1]=="")[1]+3
    stop=which(data[,1]=="")[2]-2
    
    #Skip to next if file is empty
    if(ncol(data)<2) next
    if(is.na(which(data[,1]=="")[2]-2)) next
    
    data=data[start:stop,]
    data[,1]=as.character(data[,1])
    
    #Convert all columns except date column into numeric
    for(j in 2:ncol(data)) data[,j]=as.numeric(as.character(data[,j]))
    
    #FORMAT DATE
    len=nchar(data[1,1])
    
    #Monthly data
    if(len==7) {
      data[,1]=as.Date(paste(data[,1], "-1", sep=""), "%Y-%m-%d")
      data[,1]=sapply(data[,1], seq, length=2, by="1 month")[2,]-1
      data[,1]=as.Date(data[,1], "%Y-%m-%d", origin="1970-01-01")
    }
    
    #Weekly data
    if(len==23){
      data[,1]=sapply(data[,1], substr, start=14, stop=30)
      data[,1]=as.Date(data[,1], "%Y-%m-%d")
    }
    
    #Daily data
    if(len==10) data[,1]=as.Date(data[,1], "%Y-%m-%d")
    
    #Structure into panel data format
    panelData=data[1:2]
    panelData[3]=name[1]
    names(panelData)=c("Date", "SVI", "Keyword")
    if(ncol(data)>2) {
      
      for(j in 3:ncol(data)) {
        appendData=data[c(1,j)]
        appendData[3]=name[j-1]
        names(appendData)=c("Date", "SVI", "Keyword")
        panelData=rbind(panelData, appendData)
      }
    }
    
    #Add file name  
    panelData[ncol(panelData)+1]=filePath[i]
    
    #Add path to filename
    names(panelData)[4]="Path"
    
    #Merge several several files into one
    if(i==1) output=panelData
    if(i>1) output=rbind(output, panelData)
  }
  return(output)
}
