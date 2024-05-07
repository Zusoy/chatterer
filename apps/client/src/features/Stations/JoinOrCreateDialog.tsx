import React from 'react'
import {
  Dialog,
  Card,
  Tabs,
  TabsHeader,
  Tab,
  TabsBody,
  TabPanel,
  CardBody
} from '@material-tailwind/react'
import Create from 'features/Stations/Create'
import Join from 'features/Stations/Join'
import Button from 'widgets/Buttons/Button'
import Typography from 'widgets/Texts/Typography'

type Props = {
  handler: React.Dispatch<React.SetStateAction<boolean>>,
  opened: boolean
}

const JoinOrCreateDialog: React.FC<Props> = ({ opened, handler }) => {
  return (
    <Dialog open={opened} handler={handler} size='xs' className='transition-all ease-out' placeholder={undefined}>
      <Card className="mx-auto w-full" placeholder={undefined}>
        <CardBody className="flex flex-col gap-4" placeholder={undefined}>
          <Typography variant='h3' className='text-center'>Add station</Typography>
          <Tabs value='join'>
            <TabsHeader placeholder={undefined}>
              <Tab value='join' placeholder={undefined}>Join</Tab>
              <Tab value='create' placeholder={undefined}>Create</Tab>
            </TabsHeader>
            <TabsBody placeholder={undefined}>
              <div className='w-full'>
                <TabPanel value='join' className='p-0'>
                  <Join />
                </TabPanel>
                <TabPanel value='create' className='p-0'>
                  <Create
                    onCreated={() => handler(false)}
                  />
                </TabPanel>
                <Button
                  variant='outlined'
                  className='mt-2'
                  onClick={() => handler(false)}
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
