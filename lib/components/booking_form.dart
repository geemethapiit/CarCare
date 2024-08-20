import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import 'package:http/http.dart' as http;
import '../config/auth_services.dart';
import '../config/global.dart';
import 'bottom_navigation.dart';
import 'com_button.dart';
import 'config.dart';

class BookingForm extends StatefulWidget {
  final List<Map<String, String>> services;
  final List<String> vehicles;
  final String branchId;
  final String branchName;
  final DateTime date;
  final List<String> slots;

  const BookingForm({
    Key? key,
    required this.services,
    required this.vehicles,
    required this.branchId,
    required this.branchName,
    required this.date,
    required this.slots,

  }) : super(key: key);

  @override
  State<BookingForm> createState() => _BookingFormState();
}

class _BookingFormState extends State<BookingForm> {
  String? _selectedVehicle;
  String? _selectedServiceTypeName;
  String? _selectedServiceTypeId;
  String? _selectedSlot;

  final TextEditingController _dateController = TextEditingController();
  final TextEditingController _branchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _dateController.text = DateFormat('yyyy-MM-dd').format(widget.date);
    _branchController.text = widget.branchName;
    _selectedSlot = widget.slots.isNotEmpty ? widget.slots[0] : null;
    print('Received slots: ${widget.slots}');
  }


  Future<void> bookNow() async {

    if (_selectedVehicle == null ||
        _selectedServiceTypeId == null ||
        _selectedSlot == null
        ) {
      errorSnackBar(context, 'Please fill all fields');
      return;
    }

    print('Selected Vehicle: $_selectedVehicle');
    print('Selected Service Type ID: $_selectedServiceTypeId');
    print('Selected Slot: $_selectedSlot');
    print('Date: ${DateFormat('yyyy-MM-dd').format(widget.date)}');
    print('Branch ID: ${widget.branchId}');
    print('Retrieved token: ${await AuthServices.getToken()}');

    try {
      final token = await AuthServices.getToken();
      final response = await http.post(
        Uri.parse(baseURL + '/appointments'),
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },

        body: json.encode({
          'date': DateFormat('yyyy-MM-dd').format(widget.date),
          'time': DateFormat('H:mm').format(
            DateFormat('H:mm').parse(_selectedSlot!),
          ),
          'ServiceTypeId': _selectedServiceTypeId!,
          'BranchID': widget.branchId,
          'vehicle_number': _selectedVehicle!,
        }),
      );

      print('Status code: ${response.statusCode}');
      print('Server response: ${response.body}');

      if (response.statusCode == 200) {
        ScaffoldMessenger.of(context).showSnackBar(SnackBar(
          backgroundColor: Colors.green,
          content: Text('Booking successful'),
        ));
        Navigator.push(context, MaterialPageRoute(builder: (context) => CustomBottomNavBar()));
      } else {
        final Map<String, dynamic> responseMap = json.decode(response.body);
        errorSnackBar(
            context, responseMap['message'] ?? 'Error booking appointment');
      }
    } catch (e) {
      print('Error submitting booking: $e');
      errorSnackBar(context, 'Error submitting booking');
    }
  }


  @override
  Widget build(BuildContext context) {
    // Handle the case where no slots are available
    final List<String> slots = widget.slots.isEmpty ? ['No slots available'] : widget.slots;

    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        appBar: PreferredSize(
          preferredSize: Size.fromHeight(100.0),
          child: AppBar(
            centerTitle: true,
            title: Padding(
              padding: EdgeInsets.only(top: 30.0),
              child: Text(
                'Appointment Application',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 24,
                  color: Colors.white,
                ),
              ),
            ),
            backgroundColor: Colors.deepPurple.shade400,
          ),
        ),
        body: SingleChildScrollView(
          child: Padding(
            padding: EdgeInsets.symmetric(horizontal: 40.0),
            child: SafeArea(
              child: Column(
                mainAxisAlignment: MainAxisAlignment.start,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Config.spaceSmall,
                  Config.spaceSmall,
                  Container(
                    padding: EdgeInsets.all(20.0),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: Form(
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.start,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Config.spaceSmall,
                          TextField(
                            controller: _dateController,
                            decoration: InputDecoration(
                              labelText: 'Date',
                              border: OutlineInputBorder(),
                            ),
                            readOnly: true,
                          ),
                          Config.spaceSmall,
                          TextField(
                            controller: _branchController,
                            decoration: InputDecoration(
                              labelText: 'Branch',
                              border: OutlineInputBorder(),
                            ),
                            readOnly: true,
                          ),
                          Config.spaceSmall,
                          DropdownButtonFormField<String>(
                            decoration: InputDecoration(
                              labelText: 'Select Service Type',
                            ),
                            value: _selectedServiceTypeName,
                            onChanged: (String? newValue) {
                              setState(() {
                                _selectedServiceTypeName = newValue;
                                _selectedServiceTypeId =
                                widget.services.firstWhere(
                                      (service) =>
                                  service['ServiceTypeName'] == newValue,
                                  orElse: () => {'ServiceTypeID': ''},
                                )['ServiceTypeID'];
                              });
                            },
                            items: widget.services.map((service) {
                              return DropdownMenuItem<String>(
                                value: service['ServiceTypeName'],
                                child: Text(service['ServiceTypeName']!),
                              );
                            }).toList(),
                          ),
                          Config.spaceSmall,
                          DropdownButtonFormField<String>(
                            decoration: InputDecoration(
                              labelText: 'Select Time Slot',
                            ),
                            value: _selectedSlot,
                            onChanged: (String? newValue) {
                              setState(() {
                                _selectedSlot = newValue;
                              });
                            },
                            items: slots.map((slot) {
                              return DropdownMenuItem<String>(
                                value: slot,
                                child: Text(
                                  slot,
                                  style: TextStyle(
                                    color: slot == 'No slots available'
                                        ? Colors.red
                                        : Colors.black,
                                  ),
                                ),
                              );
                            }).toList(),
                          ),
                          Config.spaceSmall,
                          DropdownButtonFormField<String>(
                            decoration: InputDecoration(
                              labelText: 'Select Vehicle',
                            ),
                            value: _selectedVehicle,
                            onChanged: (String? newValue) {
                              setState(() {
                                _selectedVehicle = newValue;
                              });
                            },
                            items: widget.vehicles.map((vehicle) {
                              return DropdownMenuItem<String>(
                                value: vehicle,
                                child: Text(vehicle),
                              );
                            }).toList(),
                          ),
                          Config.spaceSmall,
                          Padding(
                            padding: EdgeInsets.all(10.0),
                            child: ComButton(
                              width: 300,
                              height: 50,
                              title: 'Book Now',
                              disable: false,
                              color: '#512DA8',
                              onPressed: bookNow,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}