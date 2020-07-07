# I started this to create a filter that would translate netbox to linux-system-roles/network.

from ansible.utils.display import Display

display = Display()

def get_type(intf_type):
  # This is not ideal.  Fix it.
  # https://github.com/netbox-community/netbox/blob/3eb2d45e8deedfc71cfba9a3c2f919df760b6dca/netbox/dcim/migrations/0082_3569_interface_fields.py
  if intf_type['id'] == 0:
    return 'vlan'
  elif 799 < intf_type['id'] < 2000:
    return 'ethernet'
  elif intf_type['id'] == 200:
    return 'bond'


def translate_interface(interface):
  display.vv(interface)

  lsrint = {
    'name': interface['name'],
    'interface_name': interface['name'],
    'state': 'up' if interface['enabled'] else 'down',
    'persistent_state': 'present' if interface['enabled'] else 'absent',
  }
  lsrint['type'] = get_type(interface['type'])

  if lsrint['type'] == "vlan":
    #Interface name must be in the format <intf>.<vlan>
    lsrint['parent'] = interface['name'].split('.',1)[0]

  if interface.get('ip_address'):
    lsrint['ip']['address'] = [ ip['address'] for ip in interface['ip_addresses'] ]

  return lsrint

def nbint_to_lsr_network(interfaces):
  return [ translate_interface(netif) for netif in interfaces ]

class FilterModule(object):
    def filters(self):
      return {'nbint_to_lsr_network': nbint_to_lsr_network}
