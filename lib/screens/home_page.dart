import 'package:carcareproject/components/config.dart';
import 'package:carcareproject/components/ongoingcard.dart';
import 'package:flutter/material.dart';
import 'dart:async';
import 'package:lottie/lottie.dart';
import 'package:http/http.dart' as http;
import '../config/auth_services.dart';
import '../config/global.dart';
import 'branches.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  final PageController _pageController = PageController(initialPage: 0);
  final List<String> _images = [
    'assets/images/car_wash.jpg',
    'assets/images/carcar.jpg',
    'assets/images/carfront.jpg',
    'assets/images/carback.jpg',
  ];
  int _currentPage = 0;
  late Timer _timer;

  List<OngoingCard> ongoingAppointments = [];
  bool isOngoingLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchOngoingAppointments();
    _timer = Timer.periodic(Duration(seconds: 5), (Timer timer) {
      if (_currentPage < _images.length - 1) {
        _currentPage++;
      } else {
        _currentPage = 0;
      }

      _pageController.animateToPage(
        _currentPage,
        duration: Duration(milliseconds: 200),
        curve: Curves.easeIn,
      );
    });
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

      if (response.statusCode == 200 || response.statusCode == 204) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Appointment canceled successfully')),
        );
        setState(() {
          ongoingAppointments.removeWhere((appointment) =>
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


  void _fetchOngoingAppointments() async {
    try {
      final List<Map<String, String>> ongoingAppointmentsData = await AuthServices.fetchOngoingAppointments();
      for (Map<String, String> appointment in ongoingAppointmentsData) {
        ongoingAppointments.add(OngoingCard(
          appointmentID: appointment['appointmentID'] ?? 'N/A',
          serviceType: appointment['serviceType'] ?? 'Unknown Service',
          branch: appointment['branch'] ?? 'Unknown Branch',
          status: appointment['status'] ?? 'Unknown Status',
          date: appointment['date'] ?? 'Unknown Date',
          time: appointment['time'] ?? 'Unknown Time',
          onRemove: () => _confirmDelete(appointment['appointmentID'] ?? 'N/A',
          ),
        ));
      }

      setState(() {
        isOngoingLoading = false; // Set to false after data is fetched
      });
    } catch (e) {
      print('Error fetching ongoing appointments: $e');
      setState(() {
        isOngoingLoading = false; // Ensure loading is false even if there's an error
      });
    }
  }

  @override
  void dispose() {
    _timer.cancel();
    _pageController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: Config.gradientBackground,
      child: Scaffold(
        backgroundColor: Colors.transparent,
        body: SingleChildScrollView(
          child: SafeArea(
            child: Column(
              children: [
                Container(
                  height: 250,
                  child: PageView.builder(
                    controller: _pageController,
                    itemCount: _images.length,
                    itemBuilder: (context, index) {
                      return AnimatedBuilder(
                        animation: _pageController,
                        builder: (context, child) {
                          double value = 1.0;
                          if (_pageController.position.haveDimensions) {
                            value = _pageController.page! - index;
                            value = (1 - (value.abs() * 0.3)).clamp(0.0, 1.0);
                          }
                          return Center(
                            child: Transform.scale(
                              scale: value,
                              child: Container(
                                margin: EdgeInsets.symmetric(horizontal: 10),
                                child: Material(
                                  elevation: 5,
                                  borderRadius: BorderRadius.circular(10),
                                  child: ClipRRect(
                                    borderRadius: BorderRadius.circular(10),
                                    child: Image.asset(
                                      _images[index],
                                      width: double.infinity,
                                      fit: BoxFit.cover,
                                    ),
                                  ),
                                ),
                              ),
                            ),
                          );
                        },
                      );
                    },
                  ),
                ),
                Config.spaceSmall,
                Row(
                  children: [
                    SizedBox(
                      width: 200, // Set the desired width
                      height: 200, // Set the desired height
                      child: Lottie.asset('assets/lottie/MR.json'),
                    ),
                    Text(
                      "Get Your Car in Gear \n All Your Service Needs \n in One Spot!",
                      style: TextStyle(
                        fontSize: 20,
                        color: Colors.black,
                        fontFamily: 'Roboto',
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ],
                ),
                Config.spaceSmall,
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    Container(
                      width: 250,
                      height: 100,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(20),
                        color: Colors.white,
                      ),
                      child: IconButton(
                        icon: Icon(Icons.directions_car),
                        iconSize: 80.0,
                        onPressed: () {
                          Navigator.pushNamed(context, '/car');
                        },
                      ),
                    ),
                    Container(
                      width: 150,
                      height: 100,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(20),
                        color: Colors.white,
                      ),
                      child: IconButton(
                        icon: Icon(Icons.store),
                        iconSize: 80.0,
                        onPressed: () {
                          Navigator.push(context, MaterialPageRoute(builder: (context) => BranchedPage()));
                        },
                      ),
                    ),
                  ],
                ),
                Config.spaceSmall,
                isOngoingLoading
                    ? const Center(child: CircularProgressIndicator())
                    : ongoingAppointments.isNotEmpty
                    ? Padding(
                  padding: const EdgeInsets.all(10),
                  child: Column(
                    children: [
                      Align(
                        alignment: Alignment.centerLeft,
                    child: Padding(
                      padding: const EdgeInsets.all(8.0),
                    child:
                      Text(
                        "Your Ongoing Appointments",
                        style: TextStyle(
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                          color: Colors.black,
                        ),
                      ),
                    ),
                      ),
                      ListView.builder(
                        physics: const NeverScrollableScrollPhysics(),
                        shrinkWrap: true,
                        itemCount: ongoingAppointments.length,
                        itemBuilder: (context, index) {
                          return ongoingAppointments[index];
                        },
                      ),
                    ],
                  ),
                )
                    : Container(), // Show nothing if there are no ongoing appointments
              ],
            ),
          ),
        ),
      ),
    );
  }
}
