import 'package:carcareproject/Components/com_button.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:pdf/pdf.dart';
import 'package:pdf/widgets.dart' as pw;
import 'package:printing/printing.dart';

class BatteryRecord extends StatefulWidget {
  const BatteryRecord({super.key});

  @override
  State<BatteryRecord> createState() => _BatteryRecordState();
}

class _BatteryRecordState extends State<BatteryRecord> {
  final List<DataRow> tableRows = const [
    DataRow(cells: [
      DataCell(Text('2024-08-01')),
      DataCell(Text('R')),
      DataCell(Text('RP')),
      DataCell(Text('TP')),
      DataCell(Text('RP')),
      DataCell(Text('78415')),
      DataCell(Text('Supun')),
    ]),
    DataRow(cells: [
      DataCell(Text('2024-08-01')),
      DataCell(Text('R')),
      DataCell(Text('RP')),
      DataCell(Text('TP')),
      DataCell(Text('RP')),
      DataCell(Text('78415')),
      DataCell(Text('Supun')),
    ]),
    DataRow(cells: [
      DataCell(Text('2024-08-01')),
      DataCell(Text('R')),
      DataCell(Text('RP')),
      DataCell(Text('TP')),
      DataCell(Text('RP')),
      DataCell(Text('78415')),
      DataCell(Text('Supun')),
    ]),
  ];

  Future<void> generatePdf() async {
    final pdf = pw.Document();
    final image = pw.MemoryImage(
      (await rootBundle.load('assets/images/logo_new.png')).buffer.asUint8List(),
    );


    pdf.addPage(
      pw.Page(
        pageFormat: PdfPageFormat.a3.landscape,
        build: (pw.Context context) {
          return pw.Column(
            crossAxisAlignment: pw.CrossAxisAlignment.start,
            children: [
              pw.Container(
                decoration: pw.BoxDecoration(
                  color: PdfColor.fromHex('#D1C4E7'),
                ),
                child: pw.Column(
                  children: [
                    pw.Image(image),
                    pw.SizedBox(height: 20),
                    pw.Center(
                      child: pw.Text(
                        "Vehicle Battery Service Record",
                        style: pw.TextStyle(fontSize: 28, fontWeight: pw.FontWeight.bold),
                      ),
                    ),
                    pw.SizedBox(height: 20),
                    pw.Padding(
                      padding: const pw.EdgeInsets.all(15.0),
                      child: pw.Row(
                        mainAxisAlignment: pw.MainAxisAlignment.spaceBetween,
                        children: [
                          pw.Text(
                            "Vehicle Number: 1234",
                            style: pw.TextStyle(fontSize: 20),
                          ),
                          pw.SizedBox(width: 20),
                          pw.Text(
                            "Engine Oil: 10W-40",
                            style: pw.TextStyle(fontSize: 20),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
              pw.SizedBox(height: 40),
              pw.Table(
                border: pw.TableBorder.all(),
                children: [
                  // Table header
                  pw.TableRow(
                    children: [
                      rotatedHeaderText('Date'),
                      rotatedHeaderText('Engine Oil'),
                      rotatedHeaderText('Clutch Fluid'),
                      rotatedHeaderText('Brake Oil'),
                      rotatedHeaderText('Coolant'),
                      rotatedHeaderText('Km Reading'),
                      rotatedHeaderText('Supervisor'),
                    ],
                  ),
                  // Table rows
                  ...tableRows.map((dataRow) {
                    return pw.TableRow(
                      children: dataRow.cells.map((dataCell) {
                        final cellText = (dataCell.child as Text).data ?? '';
                        return pw.Padding(
                          padding: const pw.EdgeInsets.all(5.0),
                          child: pw.Text(cellText, textAlign: pw.TextAlign.center),
                        );
                      }).toList(),
                    );
                  }),
                ],
              ),
            ],
          );
        },
      ),
    );


    await Printing.layoutPdf(
      onLayout: (PdfPageFormat format) async => pdf.save(),
    );
  }

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
        scrollDirection: Axis.horizontal,
        child: Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
          Padding(
            padding: const EdgeInsets.all(10.0),
            child: Container(
              decoration: BoxDecoration(
                color: Colors.deepPurple.shade300,
                borderRadius: BorderRadius.circular(20),
              ),
              child: Padding(padding: const EdgeInsets.all(20.0),
                child: Column(
                  children: [
                    Row(
                      children: [
                        Text("R - Refilled",
                            style: TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                            )),
                        SizedBox(width: 40),
                        Text("EF - Flush and Refilled",
                            style: TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                            )),
                      ],
                    ),
                    SizedBox(height: 10,),
                    Row(
                      children: [
                        Text("TP - Topup",
                            style: TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                            )),

                        SizedBox(width: 40),
                        Text("RP - Replaced",
                            style: TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                            )),
                        SizedBox(width: 40),
                        Text("CL - Cleaned",
                            style: TextStyle(
                              fontSize: 15,
                              fontWeight: FontWeight.bold,
                            )),
                        SizedBox(width: 40),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
          Padding(
            padding: const EdgeInsets.only(left: 16.0, top: 20.0),
            child: ComButton(
                width: 200,
                height: 50,
                title: "Download",
                disable: false,
                color: '#512DA8',
                onPressed: () {
                  generatePdf();
                }),
          ),
          Container(
            padding: const EdgeInsets.all(16.0),
            child: DataTable(
              columns: const [
                DataColumn(
                    label: Text('Date',
                        style: TextStyle(fontWeight: FontWeight.bold))),
                DataColumn(
                    label: Text('Engine \n Oil',
                        style: TextStyle(fontWeight: FontWeight.bold))),
                DataColumn(
                    label: Text('Clutch \n Fluid',
                        style: TextStyle(fontWeight: FontWeight.bold))),
                DataColumn(
                    label: Text('Brake \n Oil',
                        style: TextStyle(fontWeight: FontWeight.bold))),
                DataColumn(
                    label: Text('Coolant',
                        style: TextStyle(fontWeight: FontWeight.bold))),
                DataColumn(
                    label: Text('Km \nReading',
                        style: TextStyle(fontWeight: FontWeight.bold))),
                DataColumn(
                    label: Text('Supervisor',
                        style: TextStyle(fontWeight: FontWeight.bold))),
              ],
              rows: tableRows,
            ),
          ),
        ]));
  }
}

pw.Widget rotatedHeaderText(String text) {
  return pw.Container(
    alignment: pw.Alignment.center,
    padding: const pw.EdgeInsets.all(2), // Adjust padding as needed
    height: 200, // Set a fixed height for the header cells
    child: pw.Transform.rotate(
      angle: 3.14 / 2, // Rotate by -90 degrees (counterclockwise)
      child: pw.Text(
        text,
        style: pw.TextStyle(fontWeight: pw.FontWeight.bold, fontSize: 8.5),
        textAlign: pw.TextAlign.center,
      ),
    ),
  );
}