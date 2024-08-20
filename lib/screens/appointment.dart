import 'package:carcareproject/components/appointmenthistory.dart';
import 'package:carcareproject/components/checkslots.dart';
import 'package:flutter/material.dart';
import '../Components/com_button.dart';
import '../Components/config.dart';
import '../components/ongoingcard.dart';
import '../config/auth_services.dart';
import '../config/global.dart';
import 'package:http/http.dart' as http;

class Appointment extends StatefulWidget {
  const Appointment({super.key});

  @override
  State<Appointment> createState() => _AppointmentState();
}

class _AppointmentState extends State<Appointment> {
  List<bool> isSelected = [true, false];
  final List<HistoryCard> history = [];
  final List<OngoingCard> ongoing = [];
  bool isListLoading = true;
  String appointmentID = '';

  @override
  void initState() {
    super.initState();
    _fetchAppointmentData();
  }

  void _fetchAppointmentData() async {
    try {
      // Fetch appointment history
      final List<Map<String, String>> historyAppointments = await AuthServices.fetchAppointmentHistory();
      for (Map<String, String> appointment in historyAppointments) {
        history.add(HistoryCard(
          appointmentID: appointment['appointmentID'] ?? 'N/A',
          serviceType: appointment['serviceType'] ?? 'Unknown Service',
          branch: appointment['branch'] ?? 'Unknown Branch',
          status: appointment['status'] ?? 'Unknown Status',
          date: appointment['date'] ?? 'Unknown Date',
          time: appointment['time'] ?? 'Unknown Time',
        ));
      }

      // Fetch ongoing appointments
      final List<Map<String, String>> ongoingAppointments = await AuthServices.fetchOngoingAppointments();
      for (Map<String, String> appointment in ongoingAppointments) {
        ongoing.add(OngoingCard(
          appointmentID: appointment['appointmentID'] ?? '',
          serviceType: appointment['serviceType'] ?? 'Unknown Service',
          branch: appointment['branch'] ?? 'Unknown Branch',
          status: appointment['status'] ?? 'Unknown Status',
          date: appointment['date'] ?? 'Unknown Date',
          time: appointment['time'] ?? 'Unknown Time',
          onRemove: () {
            final id = appointment['appointmentID'];
            print('Attempting to delete appointment with ID: $id');  // Debugging
            if (id != null && id.isNotEmpty) {
              _confirmDelete(id);
            } else {
              print('Error: Invalid appointmentID');
            }
          },
        ));
      }

      setState(() {
        isListLoading = false;
      });
    } catch (e) {
      print('Error fetching appointment data: $e');
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        backgroundColor: Colors.red,
        content: Text('Failed to fetch appointments'),
      ));
      setState(() {
        isListLoading = false;
      });
    }
  }

  void _navigateToBookingForm() async {
    try {
      List<Map<String, String>> branchData = await AuthServices.fetchBranches();

      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => CheckSlots(
            branches: branchData,
          ),
        ),
      );
    } catch (e) {
      print('Error navigating to BookingForm: $e');
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(
        backgroundColor: Colors.red,
        content: Text('Failed to fetch data for booking'),
      ));
    }
  }

  Future<void> _confirmDelete(String appointmentID) async {
    final result = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('Confirm Cancelation'),
        content: Text('Are you sure you want to cancel this appointment?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false),
            child: Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () => Navigator.of(context).pop(true),
            child: Text('Delete Appointment'),
            style: ElevatedButton.styleFrom(
              backgroundColor: Colors.red,
            ),
          ),
        ],
      ),
    );

    if (result == true) {
      _cancelAppointment(appointmentID);
    }
  }

  Future<void> _cancelAppointment(String appointmentID) async {
    try {
      final token = await AuthServices.getToken();
      final url = Uri.parse('$baseURL/appointments/$appointmentID/cancel');
      final response = await http.post(
        url,
        headers: {
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json',
        },
      );

      print('Uri: $url');

      if (response.statusCode == 200 || response.statusCode == 204) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Appointment canceled successfully')),
        );
        setState(() {
          ongoing.removeWhere((appointment) =>
          appointment.appointmentID == appointmentID);
        });
      } else {
        throw Exception('Failed to cancel appointment');
      }
    } catch (e) {
      print('Error canceling appointment: $e');
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to cancel appointment')),
      );
    }
  }


  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        body: SingleChildScrollView(
          child: Column(
            children: [
              Container(
                margin: EdgeInsets.only(right: 7, left: 7, top: 30),
                width: double.infinity,
                height: 300,
                decoration: BoxDecoration(
                  color: Colors.deepPurple.shade300,
                  borderRadius: BorderRadius.all(Radius.circular(30)),
                ),
                child: Padding(
                  padding: const EdgeInsets.symmetric(vertical: 20, horizontal: 30),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      const Text(
                        "Appointments",
                        style: TextStyle(
                          color: Colors.white,
                          fontSize: 24,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      Config.spaceSmall,
                      ToggleButtons(
                        isSelected: isSelected,
                        onPressed: (int index) {
                          setState(() {
                            for (int i = 0; i < isSelected.length; i++) {
                              isSelected[i] = i == index;
                            }
                          });
                        },
                        color: Colors.white,
                        selectedColor: Colors.white,
                        fillColor: Config.secondaryColor,
                        borderRadius: BorderRadius.circular(8.0),
                        borderColor: Colors.white,
                        children: const <Widget>[
                          Padding(
                            padding: EdgeInsets.symmetric(horizontal: 50.0),
                            child: Text('Ongoing'),
                          ),
                          Padding(
                            padding: EdgeInsets.symmetric(horizontal: 50.0),
                            child: Text('History'),
                          ),
                        ],
                      ),
                      Config.spaceSmall,
                      Config.spaceSmall,
                      ComButton(
                        width: 300,
                        title: "Book Your Service Now",
                        disable: false,
                        color: '#512DA8',
                        onPressed: _navigateToBookingForm,
                        height: 50,
                      ),
                    ],
                  ),
                ),
              ),
              Config.spaceSmall,
              Container(
                width: double.infinity,
                padding: const EdgeInsets.all(10),
                child: isListLoading
                    ? const Center(child: CircularProgressIndicator())
                    : Column(
                  children: [
                    ListView.builder(
                      physics: const NeverScrollableScrollPhysics(),
                      shrinkWrap: true,
                      itemCount: isSelected[0] ? ongoing.length : history.length,
                      itemBuilder: (context, index) {
                        return isSelected[0] ? ongoing[index] : history[index];
                      },
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
