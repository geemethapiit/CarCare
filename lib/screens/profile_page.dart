import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../Components/config.dart';
import '../components/feedbackform.dart';
import '../config/auth_services.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {

  void _navigateToFeedbackForm() async {
    try {
      // Fetch branches as a list of maps
      List<Map<String, String>> branchData = await AuthServices.fetchBranches();

      // Extract branch names for display in the dropdown
      List<String> branchNames = branchData.map((branch) => branch['name']!).toList();

      // Fetch services and vehicles
      List<Map<String, String>> services = await AuthServices.fetchServices();
      List<String> vehicles = await AuthServices.fetchVehicles();

      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (context) => FeedbackForm(
            branches: branchData, // Pass the list of branch maps
            services: services,
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
                    margin: const EdgeInsets.only(right: 7, left: 7, top: 30),
                    width: double.infinity,
                    height: 450,
                    decoration: BoxDecoration(
                      color: Colors.deepPurple.shade300,
                      borderRadius: BorderRadius.only(
                        bottomLeft: Radius.circular(10),
                        bottomRight: Radius.circular(10),
                        topLeft: Radius.circular(20),
                        topRight: Radius.circular(20),
                      ),
                    ),
                    child: Padding(
                      padding: const EdgeInsets.symmetric(
                          horizontal: 10, vertical: 10),
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        children: [
                          ClipOval(
                            child: Image.asset(
                              'assets/images/profile.jpg',
                              width: 100,
                              height: 100,
                              fit: BoxFit.cover,
                            ),
                          ),
                          Config.spaceSmall,
                          const Text(
                            'Oshada Perera',
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 30,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          Config.spaceSmall,
                          Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Container(
                                padding: const EdgeInsets.only(
                                    right: 25, left: 25, top: 10, bottom: 10),
                                margin: const EdgeInsets.only(right: 10),
                                height: 80,
                                decoration: BoxDecoration(
                                  color: Colors.white,
                                  borderRadius: BorderRadius.circular(10),
                                ),
                                child: Column(
                                  children: const [
                                    Text(
                                      'Your Vehicles',
                                      style: TextStyle(
                                        color: Colors.deepPurple,
                                        fontSize: 14,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(
                                      '2',
                                      style: TextStyle(
                                        color: Colors.deepPurple,
                                        fontSize: 20,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              Container(
                                padding: const EdgeInsets.only(
                                    right: 25, left: 25, top: 10, bottom: 10),
                                margin: const EdgeInsets.only(right: 10),
                                height: 80,
                                decoration: BoxDecoration(
                                  color: Colors.white,
                                  borderRadius: BorderRadius.circular(10),
                                ),
                                child: Column(
                                  children: const [
                                    Text(
                                      'Appointments',
                                      style: TextStyle(
                                        color: Colors.deepPurple,
                                        fontSize: 14,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    Text(
                                      '2',
                                      style: TextStyle(
                                        color: Colors.deepPurple,
                                        fontSize: 20,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),
                          Config.spaceSmall,
                          Config.spaceSmall,
                        ],
                      ),
                    ),
                  ),
              Padding(padding: const EdgeInsets.only(left: 50, right: 50),
                  child:
              Container(
                padding: const EdgeInsets.all(40),
                decoration: BoxDecoration(
                  color: Colors.deepPurple.shade300,
                  borderRadius: BorderRadius.only(
                    bottomLeft: Radius.circular(20),
                    bottomRight: Radius.circular(20),
                  ),
                ),
                child:
                Column(
                  children: [
                    ElevatedButton.icon(
                      onPressed: () {

                      },
                      icon: Icon(Icons.person, size: 24),
                      label: Text("Profile", style: TextStyle(fontSize: 20)),
                      style: ElevatedButton.styleFrom(
                        minimumSize: Size(400, 50),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                      ),
                    ),
                    Config.spaceSmall,
                    // feedback button
                    ElevatedButton.icon(
                      onPressed: () {
                        _navigateToFeedbackForm();
                      },
                      icon: Icon(Icons.feedback, size: 24),
                      label: Text("Feedback", style: TextStyle(fontSize: 20)),
                      style: ElevatedButton.styleFrom(
                        minimumSize: Size(400, 50),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                      ),
                    ),
                    Config.spaceSmall,
                    // self service guidelines button
                    ElevatedButton.icon(
                      onPressed: () {
                        Navigator.pushNamed(context, '/self_service');
                      },
                      icon: Icon(Icons.info, size: 24),
                      label: Text("Self Service", style: TextStyle(fontSize: 20)),
                      style: ElevatedButton.styleFrom(
                        minimumSize: Size(400, 50),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                      ),
                    ),
                    Config.spaceSmall,
                    // logout button
                    ElevatedButton.icon(
                      onPressed: () {
                        _logout(context);
                      },
                      icon: Icon(Icons.logout, size: 24),
                      label: Text("Logout", style: TextStyle(fontSize: 20)),
                      style: ElevatedButton.styleFrom(
                        minimumSize: Size(400, 50),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
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
    );
  }

  void _logout(BuildContext context) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.clear(); // Clear all saved data

    Navigator.pushNamedAndRemoveUntil(context, '/', (route) => false);
  }
}
