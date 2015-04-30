<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body{
  padding: 1em;
  background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAAQElEQVQIW2P89OvDfwYo+PHjJ4zJwMHBzsAIk0SXAKkCS2KTAEu++vQSbizIKGQAl0SXAJkGlsQmAbcT2Shk+wH0sCzAEOZW1AAAAABJRU5ErkJggg==);
}
a{
  color: #739931;
}
.page{
  max-width: 60em;
  margin: 0 auto;
}
table th,
table td{
  text-align: left;
}
table.layout{
  width: 100%;
  border-collapse: collapse;
}
table.display{
  margin: 1em 0;
}
table.display th,
table.display td{
  border: 1px solid #B3BFAA;
  padding: .5em 1em;
}

table.display th{ background: #D5E0CC; }
table.display td{ background: #fff; }

table.responsive-table{
  box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
}

@media (max-width: 30em){
    table.responsive-table{
      box-shadow: none;  
    }
    table.responsive-table thead{
      display: none; 
    }
  table.display th,
  table.display td{
    padding: .5em;
  }
    
  table.responsive-table td:nth-child(1):before{
    content: 'Number';
  }
  table.responsive-table td:nth-child(2):before{
    content: 'Name';
  }
  table.responsive-table td:nth-child(1),
  table.responsive-table td:nth-child(2){
    padding-left: 25%;
  }
  table.responsive-table td:nth-child(1):before,
  table.responsive-table td:nth-child(2):before{
    position: absolute;
    left: .5em;
    font-weight: bold;
  }
  
    table.responsive-table tr,
    table.responsive-table td{
        display: block;
    }
    table.responsive-table tr{
        position: relative;
        margin-bottom: 1em;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
    }
    table.responsive-table td{
        border-top: none;
    }
    table.responsive-table td.organisationnumber{
        background: #D5E0CC;
        border-top: 1px solid #B3BFAA;
    }
    table.responsive-table td.actions{
        position: absolute;
        top: 0;
        right: 0;
        border: none;
        background: none;
    }
}
    </style>
</head>
<body>
    <table class="layout display responsive-table">
    <thead>
        <tr>
            <th>Number</th>
            <th colspan="2">Name</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td class="organisationnumber">140406</td>
            <td class="organisationname">Stet clita kasd gubergren, no sea takimata sanctus est</td>
            <td class="actions">
                <a href="?" class="edit-item" title="Edit">Edit</a>
                <a href="?" class="remove-item" title="Remove">Remove</a>
            </td>
        </tr>

        <tr>
            <td class="organisationnumber">140412</td>
            <td class="organisationname">Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat</td>
            <td class="actions">
                <a href="?" class="edit-item" title="Edit">Edit</a>
                <a href="?" class="remove-item" title="Remove">Remove</a>
            </td>
        </tr>

        <tr>
            <td class="organisationnumber">140404</td>
            <td class="organisationname">Vel illum dolore eu feugiat nulla facilisis at vero eros</td>
            <td class="actions">
                <a href="?" class="edit-item" title="Edit">Edit</a>
                <a href="?" class="remove-item" title="Remove">Remove</a>
            </td>
        </tr>

        <tr>
            <td class="organisationnumber">140408</td>
            <td class="organisationname">Iusto odio dignissim qui blandit praesent luptatum zzril delenit</td>
            <td class="actions">
                <a href="?" class="edit-item" title="Edit">Edit</a>
                <a href="?" class="remove-item" title="Remove">Remove</a>
            </td>
        </tr>

        <tr>
            <td class="organisationnumber">140410</td>
            <td class="organisationname">
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam
            </td>
            <td class="actions">
                <a href="?" class="edit-item" title="Edit">Edit</a>
                <a href="?" class="remove-item" title="Remove">Remove</a>
            </td>
        </tr>

    </tbody>
</table>
</body>
</html>