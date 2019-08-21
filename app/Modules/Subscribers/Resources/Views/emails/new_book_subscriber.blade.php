
<html>
<head>
    <style>
        .vcard a,
        .vcard .adr {
            color: #fff;
            font-family: arial, sans-serif;
        }
        #outlook a {
            padding: 0;
        }
        .ReadMsgBody {
            width: 100%;
        }
        .ExternalClass {
            width: 100%;
        }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
            line-height: 100%;
        }
        body,
        table,
        td,
        p,
        a,
        li,
        blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
        }
        body {
            margin: 0;
            padding: 0;
        }
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }
        table {
            border-collapse: collapse !important;
        }
        body,
        #bodyTable,
        #bodyCell {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }
        #bodyCell {
            padding: 10px;
        }
        #templateContainer {
            width: 600px;
        }
        body,
        #bodyTable {
            /*@editable*/
            background-color: #ffffff;
        }
        #bodyCell {
            /*@editable*/
            /* border-top: 4px solid #BBBBBB; */
        }
        #templateContainer {
            /*@editable*/
            /* border: 1px solid #BBBBBB; */
        }
        h1 {
            /*@editable*/
            color: #000 !important;
            display: block;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 36px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            letter-spacing: normal;
            margin-top: 30px;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            /*@editable*/
            text-align: center;
        }
        h2 {
            /*@editable*/
            color: #000000 !important;
            display: block;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 20px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            letter-spacing: normal;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            /*@editable*/
            text-align: left;
        }
        h3 {
            /*@editable*/
            color: #000000 !important;
            display: block;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 17px;
            /*@editable*/
            font-style: normal;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            letter-spacing: normal;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 30px;
            margin-left: 0;
            /*@editable*/
            text-align: center;
        }
        /*
        @tab Page
    @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
    @style heading 4
    */
        h4 {
            /*@editable*/
            color: #808080 !important;
            display: block;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 14px;
            /*@editable*/
            font-style: italic;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            letter-spacing: normal;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
            /*@editable*/
            text-align: left;
        }
        /*
        @tab Header
    @tip Set the background color and bottom border for your email's preheader area.
    @theme header
    */
        #templatePreheader {
            /*@editable*/
            background-color: #F4F4F4;
            /*@editable*/
            border-bottom: 1px solid #CCCCCC;
        }
        /*
        @tab Header
    @tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
    */
        .preheaderContent {
            /*@editable*/
            color: #808080;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 10px;
            /*@editable*/
            line-height: 125%;
            /*@editable*/
            text-align: left;
        }
        /*
        @tab Header
    @tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
    */
        .preheaderContent a:link,
        .preheaderContent a:visited,
        .preheaderContent a .yshortcuts {
            /*@editable*/
            color: #606060;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }
        /*
        @tab Header
    @tip Set the background color and borders for your email's header area.
    @theme header
    */
        #templateHeader {
            /*@editable*/
            background-color: #F4F4F4;
            /*@editable*/
            border-top: 1px solid #FFFFFF;
            /*@editable*/
            border-bottom: 1px solid #CCCCCC;
        }
        /*
        @tab Header
    @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
    */
        .headerContent {
            /*@editable*/
            color: #505050;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 20px;
            /*@editable*/
            font-weight: bold;
            /*@editable*/
            line-height: 100%;
            /*@editable*/
            padding-top: 0;
            /*@editable*/
            padding-right: 0;
            /*@editable*/
            padding-bottom: 0;
            /*@editable*/
            padding-left: 0;
            /*@editable*/
            text-align: left;
            /*@editable*/
            vertical-align: middle;
        }
        /*
        @tab Header
    @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
    */
        .headerContent a:link,
        .headerContent a:visited,
        .headerContent a .yshortcuts {
            /*@editable*/
            color: #EB4102;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }
        #headerImage {
            height: auto;
            max-width: 600px;
        }
        /*
        @tab Body
    @tip Set the background color and borders for your email's body area.
    */
        #templateBody {
            /*@editable*/
            background-color: #ffffff;
            /*@editable*/
            border-top: 1px solid #FFFFFF;
            /*@editable*/
            border-bottom: 1px solid #CCCCCC;
        }
        /*
        @tab Body
    @tip Set the styling for your email's main content text. Choose a size and color that is easy to read.
    @theme main
    */
        .bodyContent {
            /*@editable*/
            color: #505050;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 16px;
            /*@editable*/
            line-height: 150%;
            padding-right: 30px;
            padding-bottom: 30px;
            padding-top: 30px;
            padding-left: 30px;
            /*@editable*/
            text-align: left;
        }
        /*
        @tab Body
    @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
    */
        .bodyContent a:link,
        .bodyContent a:visited,
        .bodyContent a .yshortcuts {
            /*@editable*/
            color: #EB4102;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }
        .bodyContent img {
            display: inline;
            height: auto;
            max-width: 560px;
        }
        .templateColumnContainer {
            display: inline;
            width: 260px;
        }
        /*
        @tab Columns
    @tip Set the background color and borders for your email's column area.
    */
        #templateColumns {
            /*@editable*/
            background-color: #F4F4F4;
            /*@editable*/
            border-top: 1px solid #FFFFFF;
            /*@editable*/
            border-bottom: 1px solid #CCCCCC;
        }
        /*
    @tip Set the styling for your email's left column content text. Choose a size and color that is easy to read.
    */
        .leftColumnContent {
            /*@editable*/
            color: #505050;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 14px;
            /*@editable*/
            line-height: 150%;
            padding-top: 0;
            padding-right: 0;
            padding-bottom: 20px;
            padding-left: 0;
            /*@editable*/
            text-align: left;
        }
        /*
        @tab Columns
    @tip Set the styling for your email's left column content links. Choose a color that helps them stand out from your text.
    */
        .leftColumnContent a:link,
        .leftColumnContent a:visited,
        .leftColumnContent a .yshortcuts {
            /*@editable*/
            color: #EB4102;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }
        /*
        @tab Columns
    @tip Set the styling for your email's right column content text. Choose a size and color that is easy to read.
    */
        .rightColumnContent {
            /*@editable*/
            color: #505050;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 14px;
            /*@editable*/
            line-height: 150%;
            padding-top: 0;
            padding-right: 0;
            padding-bottom: 20px;
            padding-left: 0;
            /*@editable*/
            text-align: left;
        }
        /*
        @tab Columns
    @tip Set the styling for your email's right column content links. Choose a color that helps them stand out from your text.
    */
        .rightColumnContent a:link,
        .rightColumnContent a:visited,
        .rightColumnContent a .yshortcuts {
            /*@editable*/
            color: #EB4102;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }
        .leftColumnContent img,
        .rightColumnContent img {
            display: inline;
            height: auto;
            max-width: 260px;
        }
        /*
        @tab Footer
    @tip Set the background color and borders for your email's footer area.
    @theme footer
    */
        #templateFooter {
            /*@editable*/
            background-color: #F4F4F4;
            /*@editable*/
            border-top: 1px solid #FFFFFF;
        }
        /*
        @tab Footer
    @tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
    @theme footer
    */
        .footerContent {
            /*@editable*/
            color: #808080;
            /*@editable*/
            font-family: Helvetica;
            /*@editable*/
            font-size: 10px;
            /*@editable*/
            line-height: 150%;
            padding-top: 20px;
            padding-right: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
            /*@editable*/
            text-align: left;
        }
        /*
        @tab Footer
    @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
    */
        .footerContent a:link,
        .footerContent a:visited,
        .footerContent a .yshortcuts,
        .footerContent a span {
            /*@editable*/
            color: #606060;
            /*@editable*/
            font-weight: normal;
            /*@editable*/
            text-decoration: underline;
        }
        @media only screen and (max-width: 480px) {
            body,
            table,
            td,
            p,
            a,
            li,
            blockquote {
                -webkit-text-size-adjust: none !important;
            }
        }
        @media only screen and (max-width: 480px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            #bodyCell {
                padding: 10px !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.
    */
            #templateContainer {
                /*@tab Mobile Styles
    @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.*/
                max-width: 600px !important;
                /*@editable*/
                width: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the first-level headings larger in size for better readability on small screens.
    */
            h1 {
                /*@editable*/
                font-size: 30px !important;
                /*@editable*/
                line-height: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the second-level headings larger in size for better readability on small screens.
    */
            h2 {
                /*@editable*/
                font-size: 20px !important;
                /*@editable*/
                line-height: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the third-level headings larger in size for better readability on small screens.
    */
            h3 {
                /*@editable*/
                font-size: 18px !important;
                /*@editable*/
                line-height: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the fourth-level headings larger in size for better readability on small screens.
    */
            h4 {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            #templatePreheader {
                display: none !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the main header image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
    */
            #headerImage {
                /*@tab Mobile Styles
    @tip Make the main header image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.*/
                height: auto !important;
                /*@editable*/
                max-width: 600px !important;
                /*@editable*/
                width: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the header content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
    */
            .headerContent {
                /*@editable*/
                font-size: 20px !important;
                /*@editable*/
                line-height: 125% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the main body image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
    */
            #bodyImage {
                /*@tab Mobile Styles
    @tip Make the main body image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.*/
                height: auto !important;
                /*@editable*/
                max-width: 560px !important;
                /*@editable*/
                width: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the body content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
    */
            .bodyContent {
                /*@editable*/
                font-size: 18px !important;
                /*@editable*/
                line-height: 125% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            .templateColumnContainer {
                display: block !important;
                width: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the column image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
    */
            .columnImage {
                /*@tab Mobile Styles
    @tip Make the column image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.*/
                height: auto !important;
                /*@editable*/
                max-width: 260px !important;
                /*@editable*/
                width: 100% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the left column content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
    */
            .leftColumnContent {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 125% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the right column content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
    */
            .rightColumnContent {
                /*@editable*/
                font-size: 16px !important;
                /*@editable*/
                line-height: 125% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            /*
            @tab Mobile Styles
    @tip Make the body content text larger in size for better readability on small screens.
    */
            .footerContent {
                /*@editable*/
                font-size: 14px !important;
                /*@editable*/
                line-height: 115% !important;
            }
        }
        @media only screen and (max-width: 480px) {
            .footerContent a {
                display: block !important;
            }
        }
    </style>
</head>
<body>
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" id="bodyTable" width="100%">
        <tbody>
        <tr>
            <td align="center" id="bodyCell" valign="top">
                <!-- BEGIN TEMPLATE // -->
                <div class="__ma__postal_address">&nbsp;</div>
                <table border="0" cellpadding="0" cellspacing="0" id="templateContainer">
                    <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN BODY // -->
                            <table bgcolor="#ebebeb" border="0" cellpadding="0" cellspacing="0" class="ct-container" style="margin: auto; background-color:#000;" width="100%">
                                <tbody>
                                <tr>
                                    <td>

                                        <table border="0" cellpadding="0" cellspacing="0" id="templateBody" width="100%">
                                            <tbody>
                                            <tr>
                                                <td class="bodyContent" mc:edit="body_content00" valign="top">
                                                    <h1 style="color:#00000; font-size:20px;font-weight:bold;">Поздравления! Ти получи БЕЗПЛАТЕН достъп до книгата '10 Златни Правила на Крипто Инвеститора'</h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bodyContent" style="padding-top:0; padding-bottom:0;"><a href="" target="_blank"><img id="bodyImage" mc:allowtext="" mc:edit="body_image" mc:label="body_image" src="{{asset('images/email.jpeg')}}"  /></a></td>
                                            </tr>
                                            <tr>
                                                <td class="bodyContent" mc:edit="body_content01" valign="top">
                                                        <a href="{{\Illuminate\Support\Facades\URL::asset('images/book.odt')}}" style="text-align: center; color: #4422EE;"><b><---- Изтегли книгата '10 Златни Правила на Крипто Инвеститора' СЕГА ----></b></a>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- // END BODY -->
                        </td>
                    </tr>

                    </tbody>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
        </tbody>
    </table>
</center>

</body>
</html>
