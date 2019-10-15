function generate_pdf(items, total,po_number, po_date,shipvia,supplier, image, note) {
  return {
    content: [
    {
      alignment: 'justify',
      columns: [
      {
        text: [
        {text: 'Bitstop Bicol Sales Center\n', fontSize: 12, bold:true},
        'WYC Bldg., J. Hernandez St.\n',
        'Naga City, Camarines Sur 4400\n',
        'PH\n',
        'james@bitbicol.com\n',
         
        ],


      },
      { 
      
          image: image,
          width: 200
       
        }
      ], 
    }, 
    {
      text: "\n Purchase Order \n\n",
      style: "header"
    }, 
    {
      columns: [
      {
        text: [
        {text: "SUPPLIER\n", fontSize: 12, bold: true},
        supplier.name + '\n',
        supplier.address + '\n' ,
        supplier.province + '\n',
        supplier.city + '\n',
        supplier.country + '\n' 
        ]
      },
      {
        text: [
        {text: "SHIP TO\n", fontSize: 12, bold: true},
        'Bitstop Bicol Sales Center\n',
        'WYC Bldg., J. Hernandez St.\n',
        'Naga City, Camarines Sur\n',
        '4400\n',
        'PH\n', 
        ]
      },
      {
        alignment: 'right',
        text: [
        {text: "P.O. NO. ", fontSize: 12, bold: true},
        po_number + '\n', 
        {text: "Date ", fontSize: 12, bold: true},
        po_date
        ]
      }
      ]
    },
    '\n\n',
     {
        canvas: [ {
             type: 'line',
              x1: 0,
              y1: 5,
              x2: 518,
              y2: 5,
              lineWidth: 0.5,
              color: '#4f90bb'
        } ]
    },
    {text: '\nSHIP VIA\n', fontSize: 12, bold:true},
    {text: shipvia +'\n\n'},

    {
      table: {
        headerRows: 1,
        widths: ['*',40,100, 60], 
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
            {text: '\n\nTOTAL:\n', bold:true},
          ]
        },
        {
          alignment: 'right',
          width: 100,
          text: [
            '\n\n',
            total
          ]
        },
      ]
    },
    '\n\n\n\n\n\n\nApproved By:    _____________________________________ \n\n Date:                  _____________________________________ \n\n'
    ,
    // {
    //   columns: [
       
    //     { 
    //       width: "30",
    //       text: [ 
    //         {text: '\n\nApproved By: \n'},
    //         {text: '\n\nDate: \n\n'},
    //       ]
    //     },
    //     { 
    //       width: "30",
    //       text: [ 
    //         {text: '\n\nApproved By: \n'},
    //         {text: '\n\nDate: \n\n'},
    //       ]
    //     },
         
    //   ]
    // },
    
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
      fontSize: 11,
      lineHeight: 1.1
    }
  };
}