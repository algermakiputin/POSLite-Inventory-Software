function generate_pdf(items, total,po_number, po_date,shipvia,supplier, image, note, invoice_date, invoice_number, customer_id) {
  return {
    content: [
    {
      alignment: 'justify',
      columns: [
      {
        width: 350,
        text: [
        {text: 'POSLite\n', fontSize: 20, bold:true},
        '\nMintal Davao City\n',
        'Davao, 8000\n',
        'support@poslite.com\n',
        '09560887535\n',  
        ],


      },
      { 
        width: "*",
        text: [
          {text: "INVOICE\n", "fontSize" : 18, bold:true, color:"#4f90bb"},
          'DATE:         '+invoice_date+'\n',
          'INVOICE#:     '+invoice_number+'\n',
          'CUSTOMER ID:  '+customer_id+'\n',
        ]
        
       
      }
      ], 
    },  
    {
      columns: [
      {
        text: [
        {text: "\n\nBILL TO\n", fontSize: 13, bold: true, },
        'John Doe\n',
        'Auckland Dorm 125 Ostrich\n' ,
        'Auckland, 6000\n', 
        ]
      }, 

      ]
    },
    '\n',
    {
        canvas: [ {
             type: 'line',
              x1: 0,
              y1: 5,
              x2: 518,
              y2: 5,
              lineWidth: 0.5,
              color: '#eee'
        } ]
    },
    '\n\n',
      

    {
      table: {
        headerRows: 1,
        widths: [40, '*',100, 60], 
        body: items,
        margin: [5,5,5,5]
      },
      
      
    },

    {
      columns: [
        {
          alignment:'left',
          width: "*",
          text: [
            {text: '\n\n' + note}
          ]
        },
        {
          alignment: 'right',
          width: 100,
          text: [ 
            {text: '\nTOTAL:\n', bold:true},
          ]
        },
        {
          alignment: 'right',
          width: 100,
          text: [
            '\n',
            total
          ]
        },
      ]
    }, 
 
    
    ],
    styles: {
      header: {
        fontSize: 22,
        bold: true,
        color: "#4f90bb"
      },
      bigger: {
        fontSize: 15,
        italics: true
      }
    },
    defaultStyle: {
      columnGap: 30,
      fontSize: 12,
      lineHeight: 1.1
    }
  };
}