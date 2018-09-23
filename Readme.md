# 宿舍报修系v1.0（php+mysql）统安装说明

作者：雨落凋殇（RLDS）

邮箱：1782832653#qq.com(#换@)

个人主页:[雨落凋殇](http://rainss.cn)

####本程序使用GPL v3 开源协议进行开源

###功能说明
1.     支持短信发送通知维修人员
2.     支持后台处理维修订单（取消。完成，重新分配维修人员等）
3.     后台分2个账号，不同帐号有不同的权限
4.     后台地址为admin目录，帐号密码在admin/admin.php下，共有2个账号（admin和manage）默认密码都是rains，你可以自己修改该文件的默认密码加密方式为MD5，简单的表达式说明md5("rains"+你的密码)
5.     后台还支持将维修记录导出为excel文档等等，更多功能自行挖掘
6.     本次的程序写得仓促，代码难免不规范，功能不完善，同时也没有使用框架开发，新的系统v2.0将使用thinkphp开发，截至目前还没动工。

### 一、安装说明
0、使用前需要将本目录下的sql文件导入数据库，注意，需支持utf8mb4编码推荐数据库版本mysql5.6

1、修改文件config.php中的数据库信息

```
<?php
error_reporting(0);
//数据库主机地址
$mysql_host = 'localhost';
//数据库用户名
$mysql_user = '';
//数据库密码
$mysql_pwd = '';
//数据库名
$mysql_db = '';
```
2、修改易班登录接口以及回调地址涉及的文件如下

index.php 第4行 第18行

myhouse.php 第12行 

operate.php 第12行

question.php 第4行

submit.php 第13行

其中index.php的第四行为一般登录接口的回调地址格式如下

```
header('location:https://oauth.yiban.cn/code/html?client_id=这里填应用appID&redirect_uri=这里填应用站内地址&state=rains');
```
关于appID以及站内地址都可以在易班品台应用详细下看到

3、关于短信通知接口不在说明，使用的是submail的邮件发送，需要了解的请去submail官网查看。配置文件在submail目录下的app_config.php我没有做任何修改，直接用的submail官方提供的sdk

order.php 第50行为发送短信的短信模板ID
admin/operate.php 第32行修改为发送短信的模板ID

注意： $submail->AddVar('floor',$floor);中的floor为短信模板中的自定义变量，详细信息请看submail官方文档，submail短信发送服务是收费的。

```
$submail->SetProject('发送短信模板ID');
```


```
mcrypt_decrypt(MCRYPT_RIJNDAEL_128, '这里改为AppSecret', $postStr, MCRYPT_MODE_CBC, '这里改为AppID');
```

AppID和AppSecre可以在 管理中心->应用详细查看

### 三、项目结构
```
C:\USERS\RLDS\DOWNLOADS\ROOM
│  config.php
│  index.php
│  log.txt
│  logo.png
│  myhouse.php
│  operate.php
│  order.php
│  question.php
│  submit.php
│  
├─admin
│  │  addPerson.php
│  │  admin.php
│  │  changehouse.php
│  │  data.php
│  │  deletePerson.php
│  │  download.php
│  │  history.php
│  │  index.php
│  │  login.php
│  │  Loginverify.php
│  │  operate.php
│  │  person.php
│  │  
│  ├─css
│  │  │  adminia-responsive.css
│  │  │  adminia.css
│  │  │  bootstrap-responsive.min.css
│  │  │  bootstrap.min.css
│  │  │  font-awesome.css
│  │  │  
│  │  └─pages
│  │          dashboard.css
│  │          faq.css
│  │          login.css
│  │          plans.css
│  │          
│  ├─font
│  │      fontawesome-webfont.eot
│  │      fontawesome-webfont.svg
│  │      fontawesome-webfont.svgz
│  │      fontawesome-webfont.ttf
│  │      fontawesome-webfont.woff
│  │      fontawesome-webfont_162a16fe.eot
│  │      
│  ├─img
│  │      body-bg.png
│  │      headshot.jpg
│  │      
│  └─js
│      │  bootstrap.js
│      │  excanvas.min.js
│      │  faq.js
│      │  jquery-1.7.2.min.js
│      │  jquery-1.7.2.min_74e92c4.js
│      │  jquery.flot.js
│      │  jquery.flot.orderBars.js
│      │  jquery.flot.pie.js
│      │  jquery.flot.resize.js
│      │  
│      └─charts
│              area.js
│              bar.js
│              line.js
│              pie.js
│              
├─class
│  │  export.php
│  │  PHPExcel.php
│  │  Template.xls
│  │  Template1.xls
│  │  Template2.xls
│  │  Template3.xls
│  │  
│  └─PHPExcel
│      │  Autoloader.php
│      │  CachedObjectStorageFactory.php
│      │  Calculation.php
│      │  Cell.php
│      │  Chart.php
│      │  Comment.php
│      │  DocumentProperties.php
│      │  DocumentSecurity.php
│      │  Exception.php
│      │  HashTable.php
│      │  IComparable.php
│      │  IOFactory.php
│      │  NamedRange.php
│      │  ReferenceHelper.php
│      │  RichText.php
│      │  Settings.php
│      │  Style.php
│      │  Worksheet.php
│      │  WorksheetIterator.php
│      │  
│      ├─CachedObjectStorage
│      │      APC.php
│      │      CacheBase.php
│      │      DiscISAM.php
│      │      ICache.php
│      │      Igbinary.php
│      │      Memcache.php
│      │      Memory.php
│      │      MemoryGZip.php
│      │      MemorySerialized.php
│      │      PHPTemp.php
│      │      SQLite.php
│      │      SQLite3.php
│      │      Wincache.php
│      │      
│      ├─CalcEngine
│      │      CyclicReferenceStack.php
│      │      Logger.php
│      │      
│      ├─Calculation
│      │  │  Database.php
│      │  │  DateTime.php
│      │  │  Engineering.php
│      │  │  Exception.php
│      │  │  ExceptionHandler.php
│      │  │  Financial.php
│      │  │  FormulaParser.php
│      │  │  FormulaToken.php
│      │  │  Function.php
│      │  │  functionlist.txt
│      │  │  Functions.php
│      │  │  Logical.php
│      │  │  LookupRef.php
│      │  │  MathTrig.php
│      │  │  Statistical.php
│      │  │  TextData.php
│      │  │  
│      │  └─Token
│      │          Stack.php
│      │          
│      ├─Cell
│      │      AdvancedValueBinder.php
│      │      DataType.php
│      │      DataValidation.php
│      │      DefaultValueBinder.php
│      │      Hyperlink.php
│      │      IValueBinder.php
│      │      
│      ├─Chart
│      │  │  Axis.php
│      │  │  DataSeries.php
│      │  │  DataSeriesValues.php
│      │  │  Exception.php
│      │  │  GridLines.php
│      │  │  Layout.php
│      │  │  Legend.php
│      │  │  PlotArea.php
│      │  │  Properties.php
│      │  │  Title.php
│      │  │  
│      │  └─Renderer
│      │          jpgraph.php
│      │          PHP Charting Libraries.txt
│      │          
│      ├─Helper
│      │      HTML.php
│      │      
│      ├─locale
│      │  ├─bg
│      │  │      config
│      │  │      
│      │  ├─cs
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─da
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─de
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─en
│      │  │  └─uk
│      │  │          config
│      │  │          
│      │  ├─es
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─fi
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─fr
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─hu
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─it
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─nl
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─no
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─pl
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─pt
│      │  │  │  config
│      │  │  │  functions
│      │  │  │  
│      │  │  └─br
│      │  │          config
│      │  │          functions
│      │  │          
│      │  ├─ru
│      │  │      config
│      │  │      functions
│      │  │      
│      │  ├─sv
│      │  │      config
│      │  │      functions
│      │  │      
│      │  └─tr
│      │          config
│      │          functions
│      │          
│      ├─Reader
│      │  │  Abstract.php
│      │  │  CSV.php
│      │  │  DefaultReadFilter.php
│      │  │  Excel2003XML.php
│      │  │  Excel2007.php
│      │  │  Excel5.php
│      │  │  Exception.php
│      │  │  Gnumeric.php
│      │  │  HTML.php
│      │  │  IReader.php
│      │  │  IReadFilter.php
│      │  │  OOCalc.php
│      │  │  SYLK.php
│      │  │  
│      │  ├─Excel2007
│      │  │      Chart.php
│      │  │      Theme.php
│      │  │      
│      │  └─Excel5
│      │      │  Color.php
│      │      │  ErrorCode.php
│      │      │  Escher.php
│      │      │  MD5.php
│      │      │  RC4.php
│      │      │  
│      │      ├─Color
│      │      │      BIFF5.php
│      │      │      BIFF8.php
│      │      │      BuiltIn.php
│      │      │      
│      │      └─Style
│      │              Border.php
│      │              FillPattern.php
│      │              
│      ├─RichText
│      │      ITextElement.php
│      │      Run.php
│      │      TextElement.php
│      │      
│      ├─Shared
│      │  │  CodePage.php
│      │  │  Date.php
│      │  │  Drawing.php
│      │  │  Escher.php
│      │  │  Excel5.php
│      │  │  File.php
│      │  │  Font.php
│      │  │  OLE.php
│      │  │  OLERead.php
│      │  │  PasswordHasher.php
│      │  │  String.php
│      │  │  TimeZone.php
│      │  │  XMLWriter.php
│      │  │  ZipArchive.php
│      │  │  ZipStreamWrapper.php
│      │  │  
│      │  ├─Escher
│      │  │  │  DgContainer.php
│      │  │  │  DggContainer.php
│      │  │  │  
│      │  │  ├─DgContainer
│      │  │  │  │  SpgrContainer.php
│      │  │  │  │  
│      │  │  │  └─SpgrContainer
│      │  │  │          SpContainer.php
│      │  │  │          
│      │  │  └─DggContainer
│      │  │      │  BstoreContainer.php
│      │  │      │  
│      │  │      └─BstoreContainer
│      │  │          │  BSE.php
│      │  │          │  
│      │  │          └─BSE
│      │  │                  Blip.php
│      │  │                  
│      │  ├─JAMA
│      │  │  │  CHANGELOG.TXT
│      │  │  │  CholeskyDecomposition.php
│      │  │  │  EigenvalueDecomposition.php
│      │  │  │  LUDecomposition.php
│      │  │  │  Matrix.php
│      │  │  │  QRDecomposition.php
│      │  │  │  SingularValueDecomposition.php
│      │  │  │  
│      │  │  └─utils
│      │  │          Error.php
│      │  │          Maths.php
│      │  │          
│      │  ├─OLE
│      │  │  │  ChainedBlockStream.php
│      │  │  │  PPS.php
│      │  │  │  
│      │  │  └─PPS
│      │  │          File.php
│      │  │          Root.php
│      │  │          
│      │  ├─PCLZip
│      │  │      gnu-lgpl.txt
│      │  │      pclzip.lib.php
│      │  │      readme.txt
│      │  │      
│      │  └─trend
│      │          bestFitClass.php
│      │          exponentialBestFitClass.php
│      │          linearBestFitClass.php
│      │          logarithmicBestFitClass.php
│      │          polynomialBestFitClass.php
│      │          powerBestFitClass.php
│      │          trendClass.php
│      │          
│      ├─Style
│      │      Alignment.php
│      │      Border.php
│      │      Borders.php
│      │      Color.php
│      │      Conditional.php
│      │      Fill.php
│      │      Font.php
│      │      NumberFormat.php
│      │      Protection.php
│      │      Supervisor.php
│      │      
│      ├─Worksheet
│      │  │  AutoFilter.php
│      │  │  BaseDrawing.php
│      │  │  CellIterator.php
│      │  │  Column.php
│      │  │  ColumnCellIterator.php
│      │  │  ColumnDimension.php
│      │  │  ColumnIterator.php
│      │  │  Dimension.php
│      │  │  Drawing.php
│      │  │  HeaderFooter.php
│      │  │  HeaderFooterDrawing.php
│      │  │  MemoryDrawing.php
│      │  │  PageMargins.php
│      │  │  PageSetup.php
│      │  │  Protection.php
│      │  │  Row.php
│      │  │  RowCellIterator.php
│      │  │  RowDimension.php
│      │  │  RowIterator.php
│      │  │  SheetView.php
│      │  │  
│      │  ├─AutoFilter
│      │  │  │  Column.php
│      │  │  │  
│      │  │  └─Column
│      │  │          Rule.php
│      │  │          
│      │  └─Drawing
│      │          Shadow.php
│      │          
│      └─Writer
│          │  Abstract.php
│          │  CSV.php
│          │  Excel2007.php
│          │  Excel5.php
│          │  Exception.php
│          │  HTML.php
│          │  IWriter.php
│          │  OpenDocument.php
│          │  PDF.php
│          │  
│          ├─Excel2007
│          │      Chart.php
│          │      Comments.php
│          │      ContentTypes.php
│          │      DocProps.php
│          │      Drawing.php
│          │      Rels.php
│          │      RelsRibbon.php
│          │      RelsVBA.php
│          │      StringTable.php
│          │      Style.php
│          │      Theme.php
│          │      Workbook.php
│          │      Worksheet.php
│          │      WriterPart.php
│          │      
│          ├─Excel5
│          │      BIFFwriter.php
│          │      Escher.php
│          │      Font.php
│          │      Parser.php
│          │      Workbook.php
│          │      Worksheet.php
│          │      Xf.php
│          │      
│          ├─OpenDocument
│          │  │  Content.php
│          │  │  Meta.php
│          │  │  MetaInf.php
│          │  │  Mimetype.php
│          │  │  Settings.php
│          │  │  Styles.php
│          │  │  Thumbnails.php
│          │  │  WriterPart.php
│          │  │  
│          │  └─Cell
│          │          Comment.php
│          │          
│          └─PDF
│                  Core.php
│                  DomPDF.php
│                  mPDF.php
│                  tcPDF.php
│                  
├─img
│      pic1.jpg
│      pic2.jpg
│      pic3.jpg
│      pic4.jpg
│      pic5.jpg
│      
└─submail
    │  app_config.php
    │  composer.json
    │  SUBMAILAutoload.php
    │  
    └─lib
            .DS_Store
            addressbookmail.php
            addressbookmessage.php
            internationalsmsmultixsend.php
            internationalsmssend.php
            internationalsmsxsend.php
            intersms.php
            mail.php
            mailsend.php
            mailxsend.php
            message.php
            messagelog.php
            messagemultixsend.php
            messagesend.php
            messagetemplatedelete.php
            messagetemplateget.php
            messagetemplatepost.php
            messagetemplateput.php
            messagexsend.php
            mobiledata.php
            mobiledatacharge.php
            mobiledatapackage.php
            mobiledatatoservice.php
            multi.php
            voice.php
            voicemultixsend.php
            voicesend.php
            voiceverify.php
            voicexsend.php
```
