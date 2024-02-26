import React from 'react'
import {
  Dialog,
  Card,
  Tabs,
  TabsHeader,
  Tab,
  TabsBody,
  TabPanel,
  CardBody,
  Button,
  Typography
} from '@material-tailwind/react'
import Create from 'features/Stations/Create'
import Join from 'features/Stations/Join'

type Props = {
  onCancel: React.MouseEventHandler
}

const JoinOrCreateDialog: React.FC<Props> = ({ onCancel }) => {
  return (
    <Dialog open={true} size='xs' className='transition-all ease-out'>
      <Card className="mx-auto w-full">
        <CardBody className="flex flex-col gap-4">
          <Typography variant='h3' className='text-center'>Add station</Typography>
          <Tabs value='join'>
            <TabsHeader>
              <Tab value='join'>Join</Tab>
              <Tab value='create'>Create</Tab>
            </TabsHeader>
            <TabsBody>
              <div className='w-full'>
                <TabPanel value='join' className='p-0'>
                  <Join />
                </TabPanel>
                <TabPanel value='create' className='p-0'>
                  <Create />
                </TabPanel>
                <Button
                  variant='outlined'
                  className='mt-2'
                  onClick={onCancel}
                  fullWidth
                >
                  Cancel
                </Button>
              </div>
            </TabsBody>
          </Tabs>
        </CardBody>
      </Card>
    </Dialog>
  )
}

export default JoinOrCreateDialog
